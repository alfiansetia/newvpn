<?php

namespace App\Services\Mikapi\DHCP;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class LeaseServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'dhcp';
        parent::$command = '/ip/dhcp-server/lease/';
        parent::$cache = false;
    }
}
