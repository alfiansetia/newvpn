<?php

namespace App\Services\Mikapi;

use App\Services\RouterServices;
use App\Traits\MikrotikApiCrudTrait;

class QueueServices extends RouterServices
{
    use MikrotikApiCrudTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/queue/simple/';
        parent::$cache = false;
    }
}
