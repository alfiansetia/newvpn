<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopupResurce;
use App\Models\Topup;
use App\Services\TripayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TopupUserController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['number', 'status', 'desc', 'bank_id']);
        $filters['user_id'] = auth()->id();
        $query = Topup::query()->with(['user', 'bank'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return TopupResurce::make($item)->resolve();
        })->toJson();
    }

    public function show(Topup $topup_user)
    {
        if ($topup_user->user_id != auth()->id()) {
            return $this->send_response_unauthorize('Not your Data!');
        }
        return new TopupResurce($topup_user->load(['user', 'bank']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $current = Topup::query()->where('user_id', $user->id)->where('status', 'pending')->count() ?? 0;
        if ($current > 0) {
            return $this->send_response_unauthorize($current . ' Pending Topup already exists!');
        }
        $this->validate($request, [
            'type'      => 'required|in:manual,auto',
            'bank'      => 'required_if:type,manual|exists:banks,id',
            'amount'    => 'required|integer|gt:0|lte:500000',
        ]);
        $date = date('Y-m-d');
        $date_parse = Carbon::parse($date);
        $count = Topup::whereDate('date', $date_parse)->count() ?? 0;
        $number = 'INV' . date('ymd', strtotime($date)) . str_pad(($count + 1), 3, 0, STR_PAD_LEFT);
        $param = [
            'number'    => $number,
            'date'      => date('Y-m-d H:i:s'),
            'user_id'   => $user->id,
            'bank_id'   => $request->bank,
            'type'      => $request->type,
            'amount'    => $request->amount,
        ];
        DB::beginTransaction();
        try {
            $topup_user = Topup::create($param);
            $topup_user->load(['bank', 'user']);
            if ($request->type == 'auto') {
                $data = TripayServices::create($topup_user);
                $topup_user->update([
                    'link'              => $data['checkout_url'],
                    'callback_status'   => $data['status'],
                    'cost'              => $data['total_fee'],
                    'reference'         => $data['reference'],
                    'qris_image'        => $data['qr_url'],
                    'expired_at'        => Carbon::createFromTimestamp($data['expired_time'])->format('Y-m-d H:i:s'),
                ]);
            }
            $topup_user->send_notif();
            DB::commit();
            return $this->send_response('Success Insert Data');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::info($th->getMessage());
            return $this->send_error('Error : Cannot Create Payment!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Topup $topup_user)
    {
        if ($topup_user->user_id != auth()->id()) {
            return $this->send_response_unauthorize('Not your Data!');
        }
        if ($topup_user->status != 'pending') {
            return $this->send_response_unauthorize('Cannot cancel data, status : ' . $topup_user->status);
        }
        $topup_user->update([
            'status' => 'cancel',
        ]);
        $topup_user->send_notif();
        return $this->send_response('Success cancel data!');
    }
}
