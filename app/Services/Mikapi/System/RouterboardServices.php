<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Exception;

class RouterboardServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/routerboard/';
        parent::$cache = false;
    }

    public function routerboard()
    {
        if (empty(parent::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = parent::$API->comm('/system/routerboard/print');
        return parent::cek_error($data);
    }

    public function setting()
    {
        if (empty(parent::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = parent::$API->comm('/system/routerboard/settings/print');
        return parent::cek_error($data);
    }
}
