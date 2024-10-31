<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopupResurce;
use App\Mail\DetailTopupMail;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
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
            'bank'      => 'required|exists:banks,id',
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
            'amount'    => $request->amount,
        ];
        $topup = Topup::create($param);
        Mail::to($user->email)->queue(new DetailTopupMail($topup));
        return $this->send_response('Success Insert Data');
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
        return $this->send_response('Success cancel data!');
    }
}
