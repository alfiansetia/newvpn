<?php

namespace App\Services\Mikapi\PPP;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class ActiveServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'ppp';
        parent::$command = '/ppp/active/';
        parent::$cache = false;
    }
}
