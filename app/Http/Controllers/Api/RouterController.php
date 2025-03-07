<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouterResource;
use App\Models\Port;
use App\Models\Router;
use App\Services\RouterApiServices;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RouterController extends Controller
{
    public function paginate(Request $request)
    {
        $limit = $this->get_limit($request);
        $filters = $filters = $request->only(['name', 'hsname', 'dnsname']);
        $filters['user_id'] = auth()->id();
        $data = Router::query()->with('port.vpn.server')->paginate($limit)->withQueryString();
        return RouterResource::collection($data);
    }

    public function index(Request $request)
    {
        $filters = $filters = $request->only(['name', 'hsname', 'dnsname']);
        $filters['user_id'] = auth()->id();
        $query = Router::query()->with(['port.vpn.server'])->filter($filters);
        return DataTables::eloquent($query)->setTransformer(function ($item) {
            return RouterResource::make($item)->resolve();
        })->toJson();
    }

    public function show(string $id)
    {
        $router = $this->cek_router_exists($id);
        if (!$router) {
            return $this->send_response_not_found();
        }
        return new RouterResource($router->load('user', 'port.vpn.server'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $user_router_limit = $user->router_limit;
        $count_router_user = Router::where('user_id', '=', $user->id)->count();
        if ($count_router_user >= $user_router_limit && $user->is_not_admin()) {
            return $this->send_response_unauthorize('Your account only limit ' . $user_router_limit . ' Router!');
        }
        $this->validate($request, [
            'vpn'       => 'required|integer|exists:ports,id|unique:routers,port_id',
            'name'      => 'required|min:3|max:20',
            'username'  => 'required|min:3|max:100',
            'password'  => 'required|min:3|max:200',
            'hsname'    => 'required|min:3|max:30',
            'dnsname'   => 'required|min:3|max:30',
            'contact'   => 'required|numeric|min:10',
            'url_logo'  => 'required|max:100',
            'currency'  => 'nullable|max:5',
        ]);
        $port = Port::whereRelation('vpn', 'user_id', $user->id)
            ->whereRelation('vpn', 'is_active', 1)
            ->whereRelation('vpn.server', 'is_active', 1)
            ->find($request->vpn);
        if (!$port) {
            return $this->send_response_unauthorize('Selected Port Not Available!');
        }
        $router = Router::create([
            'user_id'       => auth()->id(),
            'port_id'       => $request->vpn,
            'name'          => $request->name,
            'hsname'        => $request->hsname,
            'dnsname'       => $request->dnsname,
            'username'      => $request->username,
            'password'      => encrypt($request->password),
            'contact'       => $request->contact,
            'url_logo'      => $request->url_logo,
            'currency'      => $request->currency,
        ]);
        $router->destroy_cache();
        return $this->send_response('Router Created!');
    }

    public function update(Request $request, string $id)
    {
        $router = $this->cek_router_exists($id);
        if (!$router) {
            return $this->send_response_not_found();
        }
        $this->validate($request, [
            'vpn'       => 'required|integer|exists:ports,id|unique:routers,port_id,' . $router->id,
            'name'      => 'required|min:3|max:20',
            'username'  => 'nullable|min:3|max:100',
            'password'  => 'nullable|min:3|max:200',
            'hsname'    => 'required|min:3|max:30',
            'contact'   => 'required|numeric|min:10',
            'url_logo'  => 'required|max:100',
            'currency'  => 'nullable|max:5',
        ]);
        $port = Port::whereRelation('vpn', 'user_id', auth()->id())
            ->whereRelation('vpn', 'is_active', 1)
            ->whereRelation('vpn.server', 'is_active', 1)
            ->find($request->vpn);
        if (!$port) {
            return $this->send_response_unauthorize('Selected Port Not Available!');
        }
        $cek_router_exist = Router::where('port_id', $request->vpn)->where('id', '!=', $router->id)->first();
        if ($cek_router_exist) {
            return $this->send_response_unauthorize('The selected port is already in use on another router!');
        }
        $param = [
            'port_id'       => $request->vpn,
            'name'          => $request->name,
            'hsname'        => $request->hsname,
            'dnsname'       => $request->dnsname,
            'contact'       => $request->contact,
            'url_logo'      => $request->url_logo,
            'currency'      => $request->currency,
        ];
        if ($request->filled('password')) {
            $param['password'] = encrypt($request->password);
        }
        if ($request->filled('username')) {
            $param['username'] = $request->username;
        }
        $router->destroy_cache();
        $router->update($param);
        return $this->send_response('Router Update!');
    }

    public function destroy(string $id)
    {
        $router = $this->cek_router_exists($id);
        if (!$router) {
            return $this->send_response_not_found();
        }
        $router->destroy_cache();
        $router->delete();
        return $this->send_response('Router Deleted!');
    }

    public function destroyBatch(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|array|min:1',
            'id.*'      => 'integer|exists:routers,id',
        ]);
        $ids = $request->id;
        $deleted = Router::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        $message = 'Success Delete : ' . $deleted . ' & Fail : ' . (count($request->id) - $deleted);
        return $this->send_response($message);
    }

    public function ping(string $id)
    {
        $router = $this->cek_router_exists($id);
        if (!$router) {
            return $this->send_response_not_found();
        }
        try {
            $router->destroy_cache();
            $ping  = RouterApiServices::router($router)->ping();
            return $this->send_response('Router ' . $router->name . ' Connected!');
        } catch (Exception $e) {
            return $this->send_response('Router Not Connect : ' . $e->getMessage(), null, 500);
        }
    }

    private function cek_router_exists(string $id)
    {
        $filters['user_id'] = auth()->id();
        $router = Router::query()->filter($filters)->find($id);
        return $router;
    }
}
