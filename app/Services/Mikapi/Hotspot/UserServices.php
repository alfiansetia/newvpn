<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;
use Exception;

class UserServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/';
        parent::$path = storage_path('app/mikapi/hotspot/user');
        parent::$cache = true;
    }

    public static function get()
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = RouterApiServices::router(parent::$router)->get(parent::$command . "print");
        if (parent::$cache) {
            $cache = static::to_cache($data);
        }
        return $data;
    }
}
