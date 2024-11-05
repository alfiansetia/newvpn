<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\ProfileResource;
use App\Services\Mikapi\Hotspot\ProfileServices;
use App\Traits\DataTableTrait;
use App\Traits\RouterTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    use RouterTrait, DataTableTrait;

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = ProfileServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ProfileResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $this->setRouter($request->router, ProfileServices::class);
            $data = $this->conn->show($id);
            return new ProfileResource($data);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'shared_users'      => 'integer|gte:0',
            'rate_limit'        => 'nullable|min:5|max:25',
            'data_day'          => 'nullable|integer|between:0,365',
            'time_limit'        => 'required|date_format:H:i:s',
            'parent'            => 'nullable',
            'comment'           => 'nullable|max:100',

        ]);
        $param = [
            'name'              => $request->input('name'),
            'shared-users'      => $request->input('shared_users') == 0 ? 'unlimited' : $request->input('shared_users'),
            'rate-limit'        => $request->input('rate_limit'),
            'session-timeout'   => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'parent-queue'      => $request->input('parent') ?? 'none',
            'comment'           => $request->input('comment'),
        ];
        try {
            $this->setRouter($request->router, ProfileServices::class);
            $data = $this->conn->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'shared_users'      => 'integer|gte:0',
            'rate_limit'        => 'nullable|min:5|max:25',
            'data_day'          => 'required|integer|between:0,365',
            'time_limit'        => 'required|date_format:H:i:s',
            'parent'            => 'nullable',
            'comment'           => 'nullable|max:100',
        ]);
        $param = [
            '.id'               => $id,
            'name'              => $request->input('name'),
            'shared-users'      => $request->input('shared_users') == 0 ? 'unlimited' : $request->input('shared_users'),
            'rate-limit'        => $request->input('rate_limit'),
            'session-timeout'   => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'parent-queue'      => $request->input('parent') ?? 'none',
            'comment'           => $request->input('comment'),
        ];
        try {
            $this->setRouter($request->router, ProfileServices::class);
            $data = $this->conn->update($param);
            return response()->json(['message' => 'Success Update Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $this->setRouter($request->router, ProfileServices::class);
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
            $this->setRouter($request->router, ProfileServices::class);
            $data = $this->conn->destroy_batch($id);
            return response()->json(['message' => 'Success Delete Data!', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
