<?php

namespace App\Services\Mikapi;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;

class ReportServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/system/script/';
        parent::$cache = false;
    }

    public function get()
    {
        $data = parent::$API->comm('/system/script/print', [
            '?comment' => 'mikhmon'
        ]);
        parent::cek_error($data);
        return $data;
    }

    public function getByDay($dateMonthYear)
    {
        $data = parent::$API->comm('/system/script/print', [
            '?source' => $dateMonthYear
        ]);
        parent::cek_error($data);
        return $data;
    }

    public function getByMonth($MonthYear)
    {
        $data = parent::$API->comm('/system/script/print', [
            '?owner' => $MonthYear
        ]);
        parent::cek_error($data);
        return $data;
    }
}
