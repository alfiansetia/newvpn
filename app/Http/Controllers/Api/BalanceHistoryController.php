<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BalanceHistoryResource;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BalanceHistoryController extends Controller
{

    public function index(Request $request)
    {
        $filters['user_id'] = auth()->id();
        $query = BalanceHistory::query()->with(['user'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return BalanceHistoryResource::make($item)->resolve();
        })->toJson();
    }

    public function show(BalanceHistory $balance_history)
    {
        return new BalanceHistoryResource($balance_history->load(['user']));
    }
}
