<?php

namespace App\Services\Mikapi;

use App\Http\Resources\Mikapi\System\PackageResource;
use App\Http\Resources\Mikapi\System\ResourceResource;
use App\Http\Resources\Mikapi\System\Routerboard\RouterboardResource;
use App\Services\RouterServices;
use Exception;
use RouterOS\Query;

class DashboardServices extends RouterServices
{
    public static function get()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = self::$client;
        $packages = $response->query((new Query('/system/package/print')))->read();
        $resource = $response->query((new Query('/system/resource/print')))->read();
        $routerboard = $response->query((new Query('/system/routerboard/print')))->read();
        $hs_active = 0;
        $hs_user = 0;
        $ppp_active = 0;
        $ppp_secret = 0;
        $hs_active = $response->query((new Query('/ip/hotspot/active/print'))->equal('count-only'))->read();
        if (isset($hs_active['after']) && isset($hs_active['after']['ret'])) {
            $hs_active = $hs_active['after']['ret'];
        }
        $hs_user = $response->query((new Query('/ip/hotspot/user/print'))->equal('count-only'))->read();
        if (isset($hs_user['after']) && isset($hs_user['after']['ret'])) {
            $hs_user = $hs_user['after']['ret'];
        }
        $ppp_active = $response->query((new Query('/ppp/active/print'))->equal('count-only'))->read();
        if (isset($ppp_active['after']) && isset($ppp_active['after']['ret'])) {
            $ppp_active = $ppp_active['after']['ret'];
        }
        $ppp_secret = $response->query((new Query('/ppp/secret/print'))->equal('count-only'))->read();
        if (isset($ppp_secret['after']) && isset($ppp_secret['after']['ret'])) {
            $ppp_secret = $ppp_secret['after']['ret'];
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
