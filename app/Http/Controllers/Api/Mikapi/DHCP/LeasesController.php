<?php

namespace App\Http\Controllers\Api\Mikapi\DHCP;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\DHCP\LeasesResource;
use App\Services\Mikapi\DHCP\LeaseServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeasesController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['server', 'address', 'mac-address', 'user', 'comment']);
            $data = LeaseServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return LeasesResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = LeaseServices::routerId($request->router)->show($id);
            return new LeasesResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $data = LeaseServices::routerId($request->router)->destroy([$id]);
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
            $data = LeaseServices::routerId($request->router)->destroy($id);
            return $this->send_response('Success Delete Data!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
