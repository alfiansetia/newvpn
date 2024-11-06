<?php

namespace App\Services\Mikapi;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;
use Exception;
use RouterOS\Query;

class LogServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/log/';
        parent::$cache = false;
    }

    public function destroy()
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query('/system/logging/action/set'))->equal('numbers', 0)->equal('memory-lines', 1);
        $query2 = (new Query('/system/logging/action/set'))->equal('numbers', '0,1')->equal('memory-lines', 1000);
        $data = $response->query($query)->query($query2)->read();
        return $data;
    }
}
