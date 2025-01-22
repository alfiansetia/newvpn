<?php

namespace App\Services\Mikapi\Hotspot;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Exception;

class ProfileServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'hotspot';
        parent::$command = '/ip/hotspot/user/profile/';
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
        $schedulers = parent::$API->comm('/system/scheduler/print');
        parent::cek_error($schedulers);
        $data = parent::$API->comm(parent::$command . "print", $new_filters);
        parent::cek_error($data);
        $data = array_map(function ($item) use ($schedulers) {
            // $item['mikhmon'] = get_mikhmon_profile_data($item['on-login'] ?? '');
            $item['scheduler'] = false;
            // $getmikhmon = explode(",", $item['on-login'] ?? '');
            // if (count($getmikhmon) > 6) {
            //     $expmode = $getmikhmon[1] ?? null;
            //     if ($expmode == "rem") {
            //         $mode = "Remove";
            //     } elseif ($expmode == "ntf") {
            //         $mode = "Notice";
            //     } elseif ($expmode == "remc") {
            //         $mode = "Remove & Record";
            //     } elseif ($expmode == "ntfc") {
            //         $mode = "Notice & Record";
            //     } else {
            //         $mode = null;
            //     }
            //     $item['mikhmon']['exp_mode'] = $expmode;
            //     $item['mikhmon']['exp_mode_parse'] = $mode;
            //     $item['mikhmon']['price'] = !empty($getmikhmon[2]) ? $getmikhmon[2] : 0;
            //     $item['mikhmon']['selling_price'] = !empty($getmikhmon[4]) ? $getmikhmon[4] : 0;
            //     $item['mikhmon']['validity'] = !empty($getmikhmon[3]) ? $getmikhmon[3] : null;
            //     $item['mikhmon']['lock'] = !empty($getmikhmon[6]) ? $getmikhmon[6] : 'Disable';
            //     $item['mikhmon']['count'] = count($getmikhmon);
            // }

            foreach ($schedulers as $scheduler) {
                if (!isset($scheduler['name']) || !isset($scheduler['disabled'])) {
                    break;
                }
                if ($scheduler['name'] === $item['name'] && $scheduler['disabled'] == 'false') {
                    $item['scheduler'] = true;
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

    public static function show(string $id)
    {
        $data = parent::$API->comm(parent::$command . "print", [
            '?.id' => $id
        ]);
        parent::cek_error($data);
        if (empty($data)) {
            throw new Exception('Data Not Found!');
        }
        $schedulers = parent::$API->comm('/system/scheduler/print');
        parent::cek_error($schedulers);
        $newdata = $data[0];
        $newdata['scheduler'] = false;
        foreach ($schedulers as $scheduler) {
            if (!isset($scheduler['name']) || !isset($scheduler['disabled'])) {
                break;
            }
            if ($scheduler['name'] === $newdata['name'] && $scheduler['disabled'] == 'false') {
                $newdata['scheduler'] = true;
                break;
            }
        }
        return $newdata;
    }

    public static function store(array $param)
    {
        $id = parent::$API->comm(parent::$command . "add", $param);
        parent::cek_error($id);
        if (parent::$cache) {
            $data = static::show($id);
            $cache = static::store_item_to_cache($data);
        }
        return $id;
    }
}
