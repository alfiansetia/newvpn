<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{


    public function __construct()
    {
        $this->middleware('role:admin')->except('paginate');
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['name', 'is_active']);
        $data = Bank::query()->filter($filters)->paginate($limit)->withQueryString();
        return BankResource::collection($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $filters = $request->only(['name', 'is_active']);
        $query = Bank::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return BankResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Bank $bank)
    {
        return new BankResource($bank);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:100',
            'acc_name'      => 'required|max:100',
            'acc_number'    => 'required|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $bank = Bank::create([
            'name'          => $request->name,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'is_active'     => $request->input('is_active') == 'on',
        ]);
        return $this->send_response('Success Insert Data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        $this->validate($request, [
            'name'          => 'required|max:100',
            'acc_name'      => 'required|max:100',
            'acc_number'    => 'required|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $bank->update([
            'name'          => $request->name,
            'acc_name'      => $request->acc_name,
            'acc_number'    => $request->acc_number,
            'is_active'     => $request->input('is_active') == 'on',
        ]);
        return $this->send_response('Success Update Data');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:banks,id',
        ]);
        $ids = $request->id;
        $deleted = Bank::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }
}
