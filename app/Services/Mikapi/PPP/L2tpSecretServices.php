<?php

namespace App\Services\Mikapi\PPP;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class L2tpSecretServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'ppp';
        parent::$command = '/ppp/l2tp-secret/';
        parent::$cache = false;
    }
}
