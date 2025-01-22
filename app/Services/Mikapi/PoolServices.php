<?php

namespace App\Services\Mikapi;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class PoolServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/ip/pool/';
        parent::$cache = false;
    }
}
