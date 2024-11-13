<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class BindingServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/ip-binding/';
        parent::$cache = false;
    }
}
