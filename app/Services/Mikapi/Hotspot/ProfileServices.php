<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class ProfileServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/profile/';
        parent::$cache = false;
    }
}
