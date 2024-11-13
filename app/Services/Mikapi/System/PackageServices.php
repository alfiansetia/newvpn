<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class PackageServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/package/';
        parent::$cache = false;
    }
}
