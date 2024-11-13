<?php

namespace App\Services\Mikapi;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Exception;

class InterfaceServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/interface/';
        parent::$cache = false;
    }

    public function monitor($id)
    {
        if (empty(parent::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = parent::$API->comm('/interface/monitor-traffic', [
            'interface' => $id,
            'once'      => ''
        ]);
        return parent::cek_error($data);
    }
}
