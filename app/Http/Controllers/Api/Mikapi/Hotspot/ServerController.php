<?php

namespace App\Http\Controllers\Api\Mikapi\Hotspot;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\Hotspot\ServerResource;
use App\Services\Mikapi\Hotspot\ServerServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServerController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = ServerServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ServerResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = ServerServices::routerId($request->router)->show($id);
            return new ServerResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $disabled = filter_var($request->input('disabled'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $this->validate($request, [
            'name'              => 'required|min:2|max:25',
            'addresses-per-mac' => 'required|integer',
            'disabled'          => 'required|boolean',
        ]);
        $param = [
            'name'              => $request->input('name'),
            'addresses-per-mac' => $request->input('addresses-per-mac'),
            'disabled'          => $request->input('disabled') ? 'yes' : 'no',
        ];
        try {
            $data = ServerServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
