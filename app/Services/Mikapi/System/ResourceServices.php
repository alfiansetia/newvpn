<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class ResourceServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/resource/';
        parent::$cache = false;
    }
}
