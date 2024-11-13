<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class UserServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/';
        parent::$path = storage_path('app/mikapi/hotspot/user');
        parent::$cache = true;
    }
}
