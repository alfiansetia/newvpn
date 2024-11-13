<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class ServerProfileServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();
        $this->name = 'hotspot';
        $this->command = '/ip/hotspot/profile/';
        parent::$cache = false;
    }
}
