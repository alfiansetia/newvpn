<?php

namespace App\Services\Mikapi\PPP;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class L2tpSecretServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'ppp';
        parent::$command = '/ppp/l2tp-secret/';
        parent::$cache = false;
    }
}
