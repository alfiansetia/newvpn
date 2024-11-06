<?php

namespace App\Services\Mikapi;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;
use Exception;
use RouterOS\Query;

class InterfaceServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/interface/';
        parent::$cache = false;
    }

    public function monitor($id)
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query('/interface/monitor-traffic'))->equal('interface', $id)->equal('once', '');
        $data = $response->query($query)->read();
        return cek_error($data);
    }
}
