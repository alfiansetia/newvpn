<?php

namespace App\Services\Mikapi;

use App\Http\Resources\Mikapi\System\PackageResource;
use App\Http\Resources\Mikapi\System\ResourceResource;
use App\Http\Resources\Mikapi\System\Routerboard\RouterboardResource;
use App\Services\RouterApiServices;
use Exception;

class DashboardServices extends RouterApiServices
{
    public static function get()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        $packages = parent::$API->comm('/system/package/print');
        $resource = parent::$API->comm('/system/resource/print');
        $routerboard = parent::$API->comm('/system/routerboard/print');
        $hs_active = 0;
        $hs_user = 0;
        $ppp_active = 0;
        $ppp_secret = 0;
        try {
            $hs_active = parent::$API->comm('/ip/hotspot/active/print', ['count-only' => '']);
            parent::cek_error($hs_active);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $hs_user = parent::$API->comm('/ip/hotspot/user/print', ['count-only' => '']);
            parent::cek_error($hs_user);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $ppp_active = parent::$API->comm('/ppp/active/print', ['count-only' => '']);
            parent::cek_error($ppp_active);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $ppp_secret = parent::$API->comm('/ppp/secret/print', ['count-only' => '']);
            parent::cek_error($ppp_secret);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $data = [
            'resource'      => ResourceResource::collection($resource),
            'package'       => PackageResource::collection($packages),
            'routerboard'   => RouterboardResource::collection($routerboard),
            'hs_active'     => $hs_active,
            'hs_user'       => $hs_user,
            'ppp_active'    => $ppp_active,
            'ppp_secret'    => $ppp_secret,
        ];
        return $data;
    }
}
