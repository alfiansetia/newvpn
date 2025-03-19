<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $filters = $request->only(['date', 'type']);
        $query = Transaction::query()->filter($filters)->latest('date');
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return TransactionResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:Y-m-d|before_or_equal:today',
            'type'      => 'required|in:in,out',
            'amount'    => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
        ]);
        $transaction = Transaction::create([
            'date'      => $request->date,
            'type'      => $request->type,
            'amount'    => $request->amount,
            'desc'      => $request->desc,
        ]);
        return $this->send_response('Success Insert Data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'date'      => 'required|date_format:Y-m-d|before_or_equal:today',
            'type'      => 'required|in:in,out',
            'amount'    => 'required|integer|gte:0',
            'desc'      => 'nullable|max:200',
        ]);
        $transaction->update([
            'date'      => $request->date,
            'type'      => $request->type,
            'amount'    => $request->amount,
            'desc'      => $request->desc,
        ]);
        return $this->send_response('Success Update Data');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:transactions,id',
        ]);
        $ids = $request->id;
        $deleted = Transaction::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }

    public function summary(Request $request)
    {
        $totals = DB::table('transactions')
            ->selectRaw("type, SUM(amount) as total")
            ->whereIn('type', ['in', 'out'])
            ->groupBy('type')
            ->pluck('total', 'type');
        $in =  (int) $totals['in'] ?? 0;
        $out = (int) $totals['out'] ?? 0;
        return $this->send_response('', [
            'income'    => $in,
            'outcome'   => $out,
            'diff'      => $in - $out
        ]);
    }
}
