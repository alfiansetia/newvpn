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

    public static function get(array $filters = [])
    {
        $new_filters = [];
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $new_filters["?$key"] = $value;
            }
        }
        $actives = parent::$API->comm('/ppp/active/print');
        parent::cek_error($actives);
        $data = parent::$API->comm(parent::$command . "print", $new_filters);
        parent::cek_error($data);

        $data = array_map(function ($item) use ($actives) {
            $item['online'] = false;
            foreach ($actives as $active) {
                if (!isset($active['name'])) {
                    break;
                }
                if ($active['name'] === $item['name']) {
                    $item['online'] = true;
                    break;
                }
            }
            return $item;
        }, $data);
        if (parent::$cache) {
            $cache = static::to_cache($data);
        }
        return $data;
    }
}
