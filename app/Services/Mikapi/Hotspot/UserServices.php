<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class UserServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/';
        parent::$path = storage_path('app/mikapi/hotspot/user');
        parent::$cache = true;
    }
}
