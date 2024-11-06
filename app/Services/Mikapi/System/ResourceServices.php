<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class ResourceServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/resource/';
        parent::$cache = false;
    }
}
