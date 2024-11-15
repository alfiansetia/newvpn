<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\ResourceResource;
use App\Http\Resources\Mikapi\System\Routerboard\RouterboardResource;
use App\Http\Resources\Mikapi\System\Routerboard\SettingResource;
use App\Services\Mikapi\System\ResourceServices;
use App\Services\Mikapi\System\RouterboardServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SystemController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function resource(Request $request)
    {
        try {
            $data = ResourceServices::routerId($request->router)->get();
            return DataTables::collection($data)->setTransformer(function ($item) {
                return ResourceResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function routerboard(Request $request)
    {
        try {
            $data = RouterboardServices::routerId($request->router)->routerboard();
            return DataTables::collection($data)->setTransformer(function ($item) {
                return RouterboardResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function setting(Request $request)
    {
        try {
            $data = RouterboardServices::routerId($request->router)->setting();
            return DataTables::collection($data)->setTransformer(function ($item) {
                return SettingResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function panel(Request $request, string $panel)
    {
        // return $this->send_response('Success ' . $panel . ' Router!');
        try {
            if ($panel == 'reboot') {
                $data = RouterboardServices::routerId($request->router)->reboot();
            } elseif ($panel == 'shutdown') {
                $data = RouterboardServices::routerId($request->router)->shutdown();
            } else {
                return $this->send_response_unauthorize('Action only reboot or shutdown');
            }
            return $this->send_response('Success ' . $panel . ' Router!');
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
