<?php

namespace App\Http\Controllers\Api\Mikapi\PPP;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\PPP\L2tpSecretResource;
use App\Services\Mikapi\PPP\L2tpSecretServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class L2tpSecretController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['comment', 'address']);
            $data = L2tpSecretServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return L2tpSecretResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = L2tpSecretServices::routerId($request->router)->show($id);
            return new L2tpSecretResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'secret'            => 'nullable|max:100',
            'address'           => 'nullable|ip',
            'subnet'            => 'nullable|integer|in:0,23,24,25,26,27,28,29,30,31,32',
            'comment'           => 'nullable|max:100',
        ]);
        $address = $request->input('address') ?? '0.0.0.0';
        $subnet = $request->input('subnet');
        $slash = $request->input('subnet') == null ? '' : '/';
        $param = [
            'secret'            => $request->input('secret'),
            'address'           => $address . $slash . $subnet,
            'comment'           => $request->input('comment'),
        ];
        try {
            $data = L2tpSecretServices::routerId($request->router)->store($param);
            return $this->send_response('Success Insert Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'secret'            => 'nullable|max:100',
            'address'           => 'nullable|ip',
            'subnet'            => 'nullable|integer|in:0,23,24,25,26,27,28,29,30,31,32',
            'comment'           => 'nullable|max:100',
        ]);
        $address = $request->input('address') ?? '0.0.0.0';
        $subnet = $request->input('subnet');
        $slash = $request->input('subnet') == null ? '' : '/';
        $param = [
            'secret'            => $request->input('secret'),
            'address'           => $address . $slash . $subnet,
            'comment'           => $request->input('comment'),
        ];
        try {
            $data = L2tpSecretServices::routerId($request->router)->update($id, $param);
            return $this->send_response('Success Update Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = L2tpSecretServices::routerId($request->router)->destroy([$id]);
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
            $data = L2tpSecretServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
