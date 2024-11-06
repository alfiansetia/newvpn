<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\GroupResource;
use App\Services\Mikapi\System\GroupServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    private
        $policies = [
            'read',
            'winbox',
            'local',
            'telnet',
            'ssh',
            'ftp',
            'reboot',
            'write',
            'policy',
            'test',
            'password',
            'web',
            'sniff',
            'sensitive',
            'api',
            'romon',
            'dude',
            'tikapp',
        ];

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = GroupServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return GroupResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = GroupServices::routerId($request->router)->show($id);
            return new GroupResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'name'      => 'required|min:1|max:50',
            'skin'      => 'nullable',
            'comment'   => 'nullable|max:100',
        ];

        foreach ($this->policies as $item) {
            $rules[$item] = 'nullable|in:on';
        }

        $this->validate($request, $rules);
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'skin'              => 'nullable',
            'comment'           => 'nullable|max:100',
        ]);
        $activatedPolicies = collect($this->policies)->map(function ($item) use ($request) {
            return $request->input($item) !== 'on' ? '!' . $item : $item;
        })->implode(',');
        $param = [
            'name'      => $request->input('name'),
            'skin'      => $request->input('skin') ?? 'default',
            'comment'   => $request->input('comment'),
            'policy'    => $activatedPolicies,
        ];
        try {
            $data = GroupServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'name'      => 'required|min:1|max:50',
            'skin'      => 'nullable',
            'comment'   => 'nullable|max:100',
        ];

        foreach ($this->policies as $item) {
            $rules[$item] = 'nullable|in:on';
        }

        $this->validate($request, $rules);
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'skin'              => 'nullable',
            'comment'           => 'nullable|max:100',
        ]);
        $activatedPolicies = collect($this->policies)->map(function ($item) use ($request) {
            return $request->input($item) !== 'on' ? '!' . $item : $item;
        })->implode(',');
        $param = [
            'name'      => $request->input('name'),
            'skin'      => $request->input('skin') ?? 'default',
            'comment'   => $request->input('comment'),
            'policy'    => $activatedPolicies,
        ];
        try {
            $data = GroupServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = GroupServices::routerId($request->router)->destroy([$id]);
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
            $data = GroupServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
