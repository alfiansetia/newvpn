<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortResource;
use App\Models\Port;
use App\Models\Vpn;
use App\Services\PortServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PortController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin'])->except(['paginateUser']);
    }

    public function paginateUser(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['vpn_id', 'username', 'dst', 'to', 'user_id']);
        $filters['user_id'] = auth()->id();
        $data = Port::query()->with(['vpn.server'])->filter($filters)->paginate($limit)->withQueryString();
        return PortResource::collection($data);
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['vpn_id', 'username', 'dst', 'to', 'user_id']);
        $data = Port::query()->with(['vpn.server'])->filter($filters)->paginate($limit)->withQueryString();
        return PortResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['vpn_id', 'username', 'dst', 'to', 'user_id']);
        $query = Port::query()->with(['vpn.server'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PortResource::make($item)->resolve();
        })->toJson();
    }

    public function show(Port $port)
    {
        return new PortResource($port->load(['vpn.server']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'vpn'    => [
                'required',
                'integer',
                'exists:vpns,id',
                function ($attribute, $value, $fail) {
                    $vpn = Vpn::where('id', $value)->where('is_active', 1)->first();
                    if (!$vpn) {
                        $fail('The selected Vpn is not active.');
                    }
                }
            ],
            'dst'    => 'required|integer|gt:1|lt:10000',
            'to'     => 'required|integer|gt:1|lt:10000',
            'sync'   => 'nullable|in:on',
        ]);

        DB::beginTransaction();
        try {
            $port = Port::create([
                'vpn_id'    => $request->vpn,
                'dst'       => $request->dst,
                'to'        => $request->to,
            ]);
            if ($request->sync == 'on') {
                $port = $port->load('vpn.server');
                $service  = PortServices::server($port->vpn->server)->store($port);
            }
            DB::commit();
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, Port $port)
    {
        $this->validate($request, [
            'dst'    => 'required|integer|gt:1|lt:10000',
            'to'     => 'required|integer|gt:1|lt:10000',
            'sync'   => 'nullable|in:on',
        ]);

        DB::beginTransaction();
        try {
            $param = [
                'dst'   => $request->dst,
                'to'    => $request->to,
            ];
            $old = $port->load('vpn.server')->toArray();
            $port->update($param);
            $new = $port->fresh();
            if ($request->sync == 'on') {
                $service  = PortServices::server($port->vpn->server)->update($old, $new);
            }
            DB::commit();
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, Port $port)
    {
        DB::beginTransaction();
        try {
            $service  = PortServices::server($port->vpn->server)->destroy($port);
            $port->delete();
            DB::commit();
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroyBatch(Request $request)
    {
        return $this->send_error('This Feature not available this time!');
    }
}
