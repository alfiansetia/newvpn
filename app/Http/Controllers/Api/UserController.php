<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $request->only(['name', 'email']);
        $data = User::query()->filter($filters)->paginate($limit)->withQueryString();
        return UserResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email']);
        $query = User::query()->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return UserResource::make($item)->resolve();
        })->toJson();
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:30|min:3',
            'email'     => 'required|email:rfc,dns|unique:users,email',
            'gender'    => 'required|in:male,female',
            'phone'     => 'nullable|min:10|numeric',
            'address'   => 'nullable|max:100',
            'password'  => 'required',
            'role'      => 'nullable|in:on',
            'status'    => 'nullable|in:on',
            'verified'  => 'nullable|in:on',
            'router_limit' => 'required|integer|gte:0',
        ]);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'gender'    => $request->gender,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'password'  => Hash::make($request->password),
            'role'      => $request->role == 'on' ? 'admin' : 'user',
            'status'    => $request->status == 'on' ? 'active' : 'nonactive',
            'email_verified_at' => $request->verified == 'on' ? now() : null,
            'router_limit'      => $request->router_limit,
        ]);
        return $this->send_response('Success Insert Data');
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required|max:30|min:3',
            'email'     => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'gender'    => 'required|in:male,female',
            'phone'     => 'nullable|min:10|numeric',
            'address'   => 'nullable|max:100',
            'role'      => 'nullable|in:on',
            'status'    => 'nullable|in:on',
            'password'  => 'nullable|min:5',
            'verified'  => 'nullable|in:on',
            'router_limit' => 'required|integer|gte:0',
        ]);
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'gender'    => $request->gender,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'role'      => $request->role == 'on' ? 'admin' : 'user',
            'status'    => $request->status == 'on' ? 'active' : 'nonactive',
            'email_verified_at' => null,
            'router_limit'      => $request->router_limit,
        ];
        if ($request->verified == 'on') {
            $data['email_verified_at'] = now();
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return $this->send_response('Success Update Data');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->send_response('Success Delete Data');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:users,id',
        ]);
        $ids = $request->id;
        $deleted = User::whereIn('id', $ids)->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }
}
