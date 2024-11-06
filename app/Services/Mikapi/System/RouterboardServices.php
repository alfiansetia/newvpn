<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;
use Exception;
use RouterOS\Query;

class RouterboardServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/routerboard/';
        parent::$cache = false;
    }

    public function routerboard()
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query('/system/routerboard/print'));
        $data = $response->query($query)->read();
        return cek_error($data);
    }

    public function setting()
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query('/system/routerboard/settings/print'));
        $data = $response->query($query)->read();
        return cek_error($data);
    }
}
