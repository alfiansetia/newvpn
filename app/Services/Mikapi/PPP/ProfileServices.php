<?php

namespace App\Services\Mikapi\PPP;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class ProfileServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'ppp';
        parent::$command = '/ppp/profile/';
        parent::$cache = false;
    }
}
