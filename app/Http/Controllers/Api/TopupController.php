<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopupResurce;
use App\Models\BalanceHistory;
use App\Models\Topup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TopupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin'])->only(['update', 'destroy']);
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
        $user = auth()->user();
        $validate  = [
            'bank'      => 'required|exists:banks,id',
            'amount'    => 'required|integer|gt:0|lte:500000',
            'desc'      => 'nullable|max:200',
        ];
        if ($user->is_admin()) {
            $validate['user'] = 'required|exists:users,id';
        } else {
            $current = Topup::query()->where('user_id', $user->id)->where('status', 'pending')->count() ?? 0;
            if ($current > 0) {
                return $this->send_response_unauthorize($current . ' Pending Topup already exists!');
            }
        }
        $this->validate($request, $validate);
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
            'desc'      => $request->desc,
        ];
        if ($user->is_admin()) {
            $param['user_id'] = $request->user;
        }
        Topup::create($param);
        return $this->send_response('Success Insert Data');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topup $topup)
    {
        $validate = [
            'user'      => 'required|exists:users,id',
            'bank'      => 'required|exists:banks,id',
            'amount'    => 'required|integer|gt:0|lte:500000',
            'desc'      => 'nullable|max:200',
        ];
        if ($topup->status != 'pending') {
            $validate = [
                'desc'  => 'nullable|max:200',
            ];
        }
        $this->validate($request, $validate);
        $param  = [
            'user_id'   => $request->user,
            'bank_id'   => $request->bank,
            'amount'    => $request->amount,
            'desc'      => $request->desc,
        ];
        if ($topup->status != 'pending') {
            $param = [
                'desc'  => $request->desc,
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
                $new_user_balance_plus = $user_balance + $amount;
                $user->update([
                    'balance' => $new_user_balance_plus,
                ]);
                BalanceHistory::create([
                    'date'      => date('Y-m-d H:i:s'),
                    'user_id'   => $topup->user_id,
                    'amount'    => $amount,
                    'type'      => 'plus',
                    'before'    => $user_balance,
                    'after'     => $new_user_balance_plus,
                    'desc'      => 'Topup ' . $topup->number,
                ]);
            }
            if ($topstatus == 'done' && $reqstatus == 'cancel') {
                if ($user_balance < $amount) {
                    return $this->send_response_unauthorize('Balance user not enough!');
                }
                $new_user_balance_min = $user_balance - $amount;
                $user->update([
                    'balance' => $new_user_balance_min,
                ]);
                BalanceHistory::create([
                    'date'      => date('Y-m-d H:i:s'),
                    'user_id'   => $topup->user_id,
                    'amount'    => $amount,
                    'type'      => 'min',
                    'before'    => $user_balance,
                    'after'     => $new_user_balance_min,
                    'desc'      => 'Cancel topup ' . $topup->number,
                ]);
            }
            $topup->update([
                'status' => $reqstatus,
            ]);
            DB::commit();
            return $this->send_response('Success Update Status : ' . $topup->number . ' to : ' . $reqstatus);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error($th->getMessage());
        }
    }
}
