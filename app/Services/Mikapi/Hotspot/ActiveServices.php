<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class ActiveServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/active/';
        parent::$cache = false;
    }
}
