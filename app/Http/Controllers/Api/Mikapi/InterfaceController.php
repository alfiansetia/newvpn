<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\InterfaceResource;
use App\Services\Mikapi\InterfaceServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InterfaceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name', 'default-name']);
            $data = InterfaceServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return InterfaceResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = InterfaceServices::routerId($request->router)->show($id);
            return new InterfaceResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'      => 'required|min:2|max:25',
            'comment'   => 'nullable',
        ]);
        $param = [
            'name'      => $request->input('name'),
            'comment'   => $request->input('comment'),
        ];
        try {
            $data = InterfaceServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function monitor(Request $request, string $id)
    {
        try {
            $data = InterfaceServices::routerId($request->router)->monitor($id);
            return $this->send_response('', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
