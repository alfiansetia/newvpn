<?php

namespace App\Http\Controllers\Api\Mikapi\PPP;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\PPP\ProfileResource;
use App\Services\Mikapi\PPP\ProfileServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
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
            $data = ProfileServices::routerId($request->router)->show($id);
            return new ProfileResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|min:1|max:50',
            'only_one'          => 'nullable|in:default,yes,no',
            'local_address'     => 'nullable|ip',
            'remote_address'    => 'nullable|ip',
            'data_day'          => 'nullable|integer|between:0,365',
            'time_limit'        => 'required|date_format:H:i:s',
            'rate_limit'        => 'nullable|min:5|max:25',
            'parent'            => 'nullable',
            'comment'           => 'nullable|max:100',
        ]);
        $param = [
            'name'              => $request->input('name'),
            'only-one'          => $request->input('only_one') ?? 'default',
            'local-address'     => $request->input('local_address') ?? '0.0.0.0',
            'remote-address'    => $request->input('remote_address') ?? '0.0.0.0',
            'session-timeout'   => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'rate-limit'        => $request->input('rate_limit'),
            'parent-queue'      => $request->input('parent') ?? 'none',
            'comment'           => $request->input('comment'),
        ];
        try {
            $data = ProfileServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $validate = [
            'only_one'          => 'nullable|in:default,yes,no',
            'local_address'     => 'nullable|ip',
            'remote_address'    => 'nullable|ip',
            'data_day'          => 'nullable|integer|between:0,365',
            'time_limit'        => 'required|date_format:H:i:s',
            'rate_limit'        => 'nullable|min:5|max:25',
            'parent'            => 'nullable',
            'comment'           => 'nullable|max:100',
        ];
        if ($request->default == 'no') {
            $validate['name'] = 'required|min:1|max:50';
        }
        $this->validate($request, $validate);
        $param = [
            'only-one'          => $request->input('only_one') ?? 'default',
            'local-address'     => $request->input('local_address') ?? '0.0.0.0',
            'remote-address'    => $request->input('remote_address') ?? '0.0.0.0',
            'session-timeout'   => ($request->data_day ?? 0) . 'd ' . $request->time_limit,
            'rate-limit'        => $request->input('rate_limit'),
            'parent-queue'      => $request->input('parent') ?? 'none',
            'comment'           => $request->input('comment'),
        ];
        if ($request->default == 'no') {
            $param['name'] = $request->input('name');
        }
        try {
            $data = ProfileServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = ProfileServices::routerId($request->router)->destroy([$id]);
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
            $data = ProfileServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
