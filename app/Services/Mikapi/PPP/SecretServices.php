<?php

namespace App\Services\Mikapi\PPP;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class SecretServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'ppp';
        parent::$command = '/ppp/secret/';
        parent::$cache = false;
    }
}
