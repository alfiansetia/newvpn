<?php

namespace App\Services\Mikapi;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class QueueServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/queue/simple/';
        parent::$cache = false;
    }
}
