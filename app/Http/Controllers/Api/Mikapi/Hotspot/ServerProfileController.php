<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\ServerProfileResource;
use App\Services\Mikapi\Hotspot\ServerProfileServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServerProfileController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = ServerProfileServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ServerProfileResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = ServerProfileServices::routerId($request->router)->show($id);
            return new ServerProfileResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'              => 'required|min:2|max:25',
            'hotspot-address'   => 'nullable|ip',
            'dns-name'          => ['nullable', "regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i"],
        ]);
        $param = [
            'name'              => $request->input('name'),
            'hotspot-address'   => $request->input('hotspot-address') ?? '0.0.0.0',
            'dns-name'          => $request->input('dns-name'),
        ];
        try {
            $data = ServerProfileServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
