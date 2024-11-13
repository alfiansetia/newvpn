<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class HostServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/host/';
        parent::$cache = false;
    }
}
