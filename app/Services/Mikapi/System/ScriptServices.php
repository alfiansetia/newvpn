<?php

namespace App\Services\Mikapi\System;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class ScriptServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/script/';
        parent::$cache = false;
    }
}
