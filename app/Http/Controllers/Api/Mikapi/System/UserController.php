<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\UserResource;
use App\Services\Mikapi\System\UserServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = UserServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return UserResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = UserServices::routerId($request->router)->show($id);
            return new UserResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'password'          => 'required|min:1|max:50',
            'group'             => 'required',
            'ip_address'        => 'nullable|ip',
            'comment'           => 'nullable|max:100',
            'is_active'         => 'nullable|in:on',
        ]);
        $param = [
            'name'              => $request->input('name'),
            'pasword'           => $request->input('pasword'),
            'group'             => $request->input('group'),
            'address'           => $request->input('ip_address') ?? '0.0.0.0',
            'comment'           => $request->input('comment'),
            'disabled'          => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        try {
            $data = UserServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $param =  [
            'name'         => 'required|min:1|max:50',
            'group'        => 'required',
            'ip_address'   => 'nullable|ip',
            'comment'      => 'nullable|max:100',
            'is_active'    => 'nullable|in:on',

        ];
        if ($request->filled('password')) {
            $param['password'] = 'required|min:1|max:50';
        }
        $this->validate($request, $param);
        $param = [
            'name'         => $request->input('name'),
            'group'        => $request->input('group'),
            'address'      => $request->input('ip_address'),
            'comment'      => $request->input('comment'),
            'disabled'     => $request->input('is_active') == 'on' ? 'no' : 'yes',
        ];
        if ($request->filled('password')) {
            $param['password'] = $request->input('password');
        }
        try {
            $data = UserServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = UserServices::routerId($request->router)->destroy([$id]);
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
            $data = UserServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
