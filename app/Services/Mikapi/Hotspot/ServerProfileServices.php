<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class ServerProfileServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();
        $this->name = 'hotspot';
        $this->command = '/ip/hotspot/profile/';
        parent::$cache = false;
    }
}
