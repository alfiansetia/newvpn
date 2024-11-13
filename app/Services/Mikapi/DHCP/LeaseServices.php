<?php

namespace App\Services\Mikapi\DHCP;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class LeaseServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'dhcp';
        parent::$command = '/ip/dhcp-server/lease/';
        parent::$cache = false;
    }
}
