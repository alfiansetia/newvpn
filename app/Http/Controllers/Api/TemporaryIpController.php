<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TemporaryIpResouce;
use App\Models\TemporaryIp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TemporaryIpController extends Controller
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
        $filters = $filters = $request->only(['ip', 'server_id']);
        $query = TemporaryIp::query()->with(['server'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return TemporaryIpResouce::make($item)->resolve();
        })->toJson();
    }

    public function show(TemporaryIp $temporaryip)
    {
        return new TemporaryIpResouce($temporaryip->load('server'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'server'    => 'required|exists:servers,id',
            'ip'        => [
                'required',
                'ip',
                Rule::unique('vpns')->where(function ($query) use ($request) {
                    return $query->where('ip', $request->input('ip'))
                        ->where('server_id', $request->input('server'));
                }),
                'unique:temporary_ips,ip'
            ],
            'web'       => 'required|integer|gt:0',
            'api'       => 'required|integer|gt:0',
            'win'       => 'required|integer|gt:0',
        ]);
        $temp = TemporaryIp::create([
            'server_id' => $request->input('server'),
            'ip'        => $request->input('ip'),
            'web'       => $request->input('web'),
            'api'       => $request->input('api'),
            'win'       => $request->input('win'),
        ]);
        return $this->send_response('Success Insert Data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TemporaryIp $temporaryip)
    {
        $this->validate($request, [
            'server'    => 'required|exists:servers,id',
            'ip'        => [
                'required',
                'ip',
                Rule::unique('vpns')->where(function ($query) use ($request) {
                    return $query->where('ip', $request->input('ip'))
                        ->where('server_id', $request->input('server'));
                })->ignore($temporaryip->id),
                'unique:temporary_ips,ip,' . $temporaryip->id
            ],
            'web'       => 'required|integer|gt:0',
            'api'       => 'required|integer|gt:0',
            'win'       => 'required|integer|gt:0',
        ]);
        $temporaryip->update([
            'server_id' => $request->input('server'),
            'ip'        => $request->input('ip'),
            'web'       => $request->input('web'),
            'api'       => $request->input('api'),
            'win'       => $request->input('win'),
        ]);
        return $this->send_response('Success Update Data');
    }

    public function destroy(TemporaryIp $temporaryip)
    {
        $temporaryip->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:temporary_ips,id',
        ]);
        $ids = $request->id;
        $deleted = TemporaryIp::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }
}
