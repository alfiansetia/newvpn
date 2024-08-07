<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\UserResource;
use App\Services\Mikapi\System\UserServices;
use App\Traits\DataTableTrait;
use App\Traits\RouterTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use RouterTrait, DataTableTrait;

    public function __construct(Request $request)
    {
        $this->middleware('checkRouterExists');
    }

    public function index(Request $request)
    {
        try {
            $this->setRouter($request->router, UserServices::class);
            $query = [];
            if ($request->filled('name')) {
                $query['?name'] = $request->name;
            }
            $data = $this->conn->get($query);
            $resource = UserResource::collection($data);
            return $this->callback($resource->toArray($request), $request->dt == 'on');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $this->setRouter($request->router, UserServices::class);
            $data = $this->conn->show($id);
            return new UserResource($data);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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

        ]);
        $param = [
            'name'              => $request->input('name'),
            'pasword'           => $request->input('pasword'),
            'group'             => $request->input('group'),
            'address'           => $request->input('ip_address') ?? '0.0.0.0',
            'comment'           => $request->input('comment'),
        ];
        try {
            $this->setRouter($request->router, UserServices::class);
            $data = $this->conn->store($param);
            return response()->json(['message' => 'Success Insert Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $param =  [
            'name'         => 'required|min:1|max:50',
            'group'        => 'required',
            'ip_address'   => 'nullable|ip',
            'comment'      => 'nullable|max:100',
        ];
        if ($request->filled('password')) {
            $param['password'] = 'required|min:1|max:50';
        }
        $this->validate($request, $param);
        $param = [
            '.id'          => $id,
            'name'         => $request->input('name'),
            'group'        => $request->input('group'),
            'address'      => $request->input('ip_address') ?? '0.0.0.0',
            'comment'      => $request->input('comment'),
        ];
        if ($request->filled('password')) {
            $param['password'] = $request->input('password');
        }
        try {
            $this->setRouter($request->router, UserServices::class);
            $data = $this->conn->update($param);
            return response()->json(['message' => 'Success Update Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $this->setRouter($request->router, UserServices::class);
            $data = $this->conn->destroy($id);
            return response()->json(['message' => 'Success Delete Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy_batch(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|array|min:1|max:1000'
        ]);
        $id = $request->id;
        try {
            $this->setRouter($request->router, UserServices::class);
            $data = $this->conn->destroy_batch($id);
            return response()->json(['message' => 'Success Delete Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
