<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\PackageResource;
use App\Models\Mikapi\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $filters = $request->only(['name', 'router_id', 'router']);
        $filters['user_id'] = auth()->id();
        $data = Package::query()->withCount('customers')->paginate($limit)->withQueryString();
        return PackageResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['name', 'router_id', 'router']);
        $filters['user_id'] = auth()->id();
        $query = Package::query()->withCount(['customers'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return PackageResource::make($item)->resolve();
        })->toJson();
    }

    public function show(string $id)
    {
        $package = $this->cek_exists($id);
        if (!$package) {
            return $this->send_response_not_found();
        }
        return new PackageResource($package->load(['user', 'customers', 'router']));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $package_count = $user->packages()->count();
        if ($package_count >= 10) {
            return $this->send_response_unauthorize('Data Package Limit 10!');
        }
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'name'          => 'required|min:3|max:30',
            'speed_up'      => 'required|integer|min:0|max:1000',
            'speed_down'    => 'required|integer|min:0|max:1000',
            'price'         => 'required|integer|min:0',
            'ppn'           => 'required|integer|min:0|max:100',
            'profile'       => 'nullable|max:50',
        ]);
        $package = Package::create([
            'user_id'       => $user_id,
            'router_id'     => $request->router,
            'name'          => $request->name,
            'speed_up'      => $request->speed_up,
            'speed_down'    => $request->speed_down,
            'price'         => $request->price,
            'ppn'           => $request->ppn,
            'profile'       => $request->profile,
        ]);
        return $this->send_response('Package Created!');
    }

    public function update(Request $request, string $id)
    {
        $package = $this->cek_exists($id);
        if (!$package) {
            return $this->send_response_not_found();
        }
        $user_id = auth()->id();
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'name'          => 'required|min:3|max:30',
            'speed_up'      => 'required|integer|min:0|max:1000',
            'speed_down'    => 'required|integer|min:0|max:1000',
            'price'         => 'required|integer|min:0',
            'ppn'           => 'required|integer|min:0|max:100',
            'profile'       => 'nullable|max:50',
        ]);
        $package->update([
            'user_id'       => $user_id,
            'router_id'     => $request->router,
            'name'          => $request->name,
            'speed_up'      => $request->speed_up,
            'speed_down'    => $request->speed_down,
            'price'         => $request->price,
            'ppn'           => $request->ppn,
            'profile'       => $request->profile,
        ]);
        return $this->send_response('Package Updated!');
    }

    public function destroy(string $id)
    {
        $package = $this->cek_exists($id);
        if (!$package) {
            return $this->send_response_not_found();
        }
        $package->delete();
        return $this->send_response('Package Deleted!');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:packages,id',
        ]);
        $ids = $request->id;
        $deleted = Package::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }


    private function cek_exists(string $id)
    {
        $filters['user_id'] = auth()->id();
        $package = Package::query()->filter($filters)->find($id);
        return $package;
    }
}
