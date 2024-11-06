<?php

namespace App\Http\Controllers\Api\Mikapi\PPP;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\PPP\SecretResource;
use App\Services\Mikapi\PPP\SecretServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SecretController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = SecretServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return SecretResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = SecretServices::routerId($request->router)->show($id);
            return new SecretResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'password'          => 'nullable|max:50',
            'service'           => 'nullable|in:any,async,l2tp,ovpn,pppoe,pptp,sstp',
            'profile'           => 'required',
            'local_address'     => 'nullable|ip',
            'remote_address'    => 'nullable|ip',
            'comment'           => 'nullable|max:100',
        ]);
        $param = [
            'name'              => $request->input('name'),
            'password'          => $request->input('password'),
            'service'           => $request->input('service') ?? 'any',
            'profile'           => $request->input('profile'),
            'local-address'     => $request->input('local_address') ?? '0.0.0.0',
            'remote-address'    => $request->input('remote_address') ?? '0.0.0.0',
            'comment'           => $request->input('comment'),
        ];
        try {
            $data = SecretServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'password'          => 'nullable|max:50',
            'service'           => 'required|in:any,async,l2tp,ovpn,pppoe,pptp,sstp',
            'profile'           => 'required',
            'local_address'     => 'nullable|ip',
            'remote_address'    => 'nullable|ip',
            'comment'           => 'nullable|max:100',
            'is_active'         => 'nullable|in:on',
        ]);
        $param = [
            'name'              => $request->input('name'),
            'password'          => $request->input('password'),
            'service'           => $request->input('service') ?? 'any',
            'profile'           => $request->input('profile'),
            'local-address'     => $request->input('local_address') ?? '0.0.0.0',
            'remote-address'    => $request->input('remote_address') ?? '0.0.0.0',
            'comment'           => $request->input('comment'),
            'disabled'          => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = SecretServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = SecretServices::routerId($request->router)->destroy([$id]);
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
            $data = SecretServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
