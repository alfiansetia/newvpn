<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\BindingResource;
use App\Services\Mikapi\Hotspot\BindingServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BindingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['server', 'address', 'type', 'to-address', 'mac-address', 'comment']);
            $data = BindingServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return BindingResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = BindingServices::routerId($request->router)->show($id);
            return new BindingResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'server'        => 'required',
            'type'          => 'nullable|in:regular,bypassed,blocked',
            'address'       => 'required_without:mac|nullable|ip',
            'to_address'    => 'nullable|ip',
            'mac'           => 'required_without:address|nullable|mac_address',
            'comment'       => 'nullable|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $param = [
            'server'        => $request->input('server'),
            'type'          => $request->input('type') ?? 'regular',
            'address'       => $request->input('address') ?? '0.0.0.0',
            'to-address'    => $request->input('to_address') ?? '0.0.0.0',
            'mac-address'   => $request->input('mac') ?? '00:00:00:00:00:00',
            'comment'       => $request->input('comment'),
            'disabled'      => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = BindingServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'server'        => 'required',
            'type'          => 'required|in:regular,bypassed,blocked',
            'address'       => 'required_without:mac|nullable|ip',
            'to_address'    => 'nullable|ip',
            'mac'           => 'required_without:address|nullable|mac_address',
            'comment'       => 'nullable|max:100',
            'is_active'     => 'nullable|in:on',
        ]);
        $param = [
            'server'        => $request->input('server'),
            'type'          => $request->input('type') ?? 'regular',
            'address'       => $request->input('address') ?? '0.0.0.0',
            'to-address'    => $request->input('to_address') ?? '0.0.0.0',
            'mac-address'   => $request->input('mac') ?? '00:00:00:00:00:00',
            'comment'       => $request->input('comment'),
            'disabled'      => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = BindingServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = BindingServices::routerId($request->router)->destroy([$id]);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy_batch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|array|min:1|max:1000'
        ]);
        $id = $request->id;
        try {
            $data = BindingServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
