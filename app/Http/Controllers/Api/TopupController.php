<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopupResurce;
use App\Models\Topup;
use App\Services\TripayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TopupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['number', 'status', 'desc', 'user_id', 'bank_id']);
        $data = Topup::query()->with(['user', 'bank'])->filter($filters)->paginate($limit)->withQueryString();
        return TopupResurce::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['number', 'status', 'desc', 'user_id', 'bank_id']);
        $query = Topup::query()->with(['user', 'bank'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return TopupResurce::make($item)->resolve();
        })->toJson();
    }

    public function show(Topup $topup)
    {
        return new TopupResurce($topup->load(['user', 'bank']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user'      => 'required|exists:users,id',
            'type'      => 'required|in:manual,auto',
            'bank'      => 'required_if:type,manual|exists:banks,id',
            'amount'    => 'required|integer|gt:0|lte:500000',
            'desc'      => 'nullable|max:200',
        ]);
        $date = date('Y-m-d');
        $date_parse = Carbon::parse($date);
        $count = Topup::whereDate('date', $date_parse)->count() ?? 0;
        $number = 'INV' . date('ymd', strtotime($date)) . str_pad(($count + 1), 3, 0, STR_PAD_LEFT);
        DB::beginTransaction();
        try {
            $topup = Topup::create([
                'number'    => $number,
                'date'      => date('Y-m-d H:i:s'),
                'user_id'   => $request->user,
                'type'      => $request->type,
                'bank_id'   => $request->bank,
                'amount'    => $request->amount,
                'desc'      => $request->desc,
            ]);
            $topup->load(['bank', 'user']);
            if ($request->type == 'auto') {
                $data = TripayServices::create($topup);
                $topup->update([
                    'link'              => $data['checkout_url'],
                    'callback_status'   => $data['status'],
                    'cost'              => $data['total_fee'],
                    'reference'         => $data['reference'],
                    'qris_image'        => $data['qr_url'],
                    'expired_at'        => Carbon::createFromTimestamp($data['expired_time'])->format('Y-m-d H:i:s'),
                ]);
            }
            $topup->send_notif();
            DB::commit();
            return $this->send_response('Success Insert Data');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topup $topup)
    {
        if ($topup->status == 'pending') {
            $this->validate($request, [
                'desc'  => 'nullable|max:200',
            ]);
            $param = [
                'desc'  => $request->desc,
            ];
        } else {
            $this->validate($request, [
                'user'      => 'required|exists:users,id',
                'type'      => 'required|in:manual,auto',
                'bank'      => 'required_if:type,manual|exists:banks,id',
                'amount'    => 'required|integer|gt:0|lte:500000',
                'desc'      => 'nullable|max:200',
            ]);
            $param  = [
                'user_id'   => $request->user,
                'type'      => $request->type,
                'bank_id'   => $request->bank,
                'amount'    => $request->amount,
                'desc'      => $request->desc,
            ];
        }
        $topup->update($param);
        return $this->send_response('Success Update Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Topup $topup)
    {
        $this->validate($request, [
            'status' => 'required|in:done,cancel'
        ]);
        DB::beginTransaction();
        try {
            $reqstatus = $request->status;
            $topstatus = $topup->status;
            if (
                $reqstatus == $topstatus ||
                ($reqstatus == 'done' && $topstatus != 'pending') ||
                ($reqstatus == 'cancel' && $topstatus != 'done' && $topstatus == 'cancel')
            ) {
                return $this->send_response_unauthorize('Status Already : ' . $topup->status);
            }
            $amount = $topup->amount;
            $user = $topup->user;
            $user_balance = $user->balance;
            if ($topstatus == 'pending' && $reqstatus == 'done') {
                $user->plus_balance($amount, 'Topup ' . $topup->number);
                $topup->transaction_in();
            }
            if ($topstatus == 'done' && $reqstatus == 'cancel') {
                if ($user_balance < $amount) {
                    return $this->send_response_unauthorize('Balance user not enough!');
                }
                $user->min_balance($amount, 'Cancel topup ' . $topup->number);
                $topup->transaction_out();
            }
            $topup->update([
                'status'    => $reqstatus,
                'paid_at'   => date('Y-m-d H:i:s'),
            ]);
            $topup->send_notif();
            DB::commit();
            return $this->send_response('Success Update Status : ' . $topup->number . ' to : ' . $reqstatus);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
