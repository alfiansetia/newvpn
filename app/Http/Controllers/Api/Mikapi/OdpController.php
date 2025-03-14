<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\OdpResource;
use App\Models\Mikapi\Odp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OdpController extends Controller
{
    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $filters = $request->only(['name', 'router_id']);
        $filters['user_id'] = auth()->id();
        $data = Odp::query()->withCount('customers')->paginate($limit)->withQueryString();
        return OdpResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['name', 'router_id']);
        $filters['user_id'] = auth()->id();
        $query = Odp::query()->withCount(['customers'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return OdpResource::make($item)->resolve();
        })->toJson();
    }

    public function show(string $id)
    {
        $odp = $this->cek_exists($id);
        if (!$odp) {
            return $this->send_response_not_found();
        }
        return new OdpResource($odp->load(['user', 'customers', 'router']));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $odp_count = $user->odps()->count();
        if ($odp_count >= 10) {
            return $this->send_response_unauthorize('Data Odp Limit 10!');
        }
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'name'          => 'required|min:3|max:30',
            'max_port'      => 'required|integer|min:1|max:50',
            'lat'           => 'nullable|max:50',
            'long'          => 'nullable|max:50',
            'desc'          => 'nullable|max:50',
            'line_color'    => 'required|hex_color',
        ]);
        $odp = Odp::create([
            'user_id'       => $user_id,
            'router_id'     => $request->router,
            'name'          => $request->name,
            'max_port'      => $request->max_port,
            'lat'           => $request->lat,
            'long'          => $request->long,
            'desc'          => $request->desc,
            'line_color'    => $request->line_color,
        ]);
        return $this->send_response('Odp Created!');
    }

    public function update(Request $request, string $id)
    {
        $odp = $this->cek_exists($id);
        if (!$odp) {
            return $this->send_response_not_found();
        }
        $user_id = auth()->id();
        $this->validate($request, [
            'router' => [
                'required',
                Rule::exists('routers', 'id')->where('user_id', $user_id),
            ],
            'name'          => 'required|min:3|max:30',
            'max_port'      => 'required|integer|min:1|max:50',
            'lat'           => 'nullable|max:50',
            'long'          => 'nullable|max:50',
            'desc'          => 'nullable|max:50',
            'line_color'    => 'required|hex_color',
        ]);
        $odp->update([
            'user_id'       => $user_id,
            'router_id'     => $request->router,
            'name'          => $request->name,
            'max_port'      => $request->max_port,
            'lat'           => $request->lat,
            'long'          => $request->long,
            'desc'          => $request->desc,
            'line_color'    => $request->line_color,
        ]);
        return $this->send_response('Odp Updated!');
    }

    public function destroy(string $id)
    {
        $odp = $this->cek_exists($id);
        if (!$odp) {
            return $this->send_response_not_found();
        }
        $odp->delete();
        return $this->send_response('Odp Deleted!');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:odps,id',
        ]);
        $ids = $request->id;
        $deleted = Odp::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }


    private function cek_exists(string $id)
    {
        $filters['user_id'] = auth()->id();
        $odp = Odp::query()->filter($filters)->find($id);
        return $odp;
    }
}
