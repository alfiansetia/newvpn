<?php

namespace App\Services\Mikapi;

use App\Services\RouterApiServices;
use App\Traits\CrudApiTrait;
use Exception;

class LogServices extends RouterApiServices
{
    use CrudApiTrait;

    public function __construct()
    {
        parent::__construct();

        parent::$name = 'system';
        parent::$command = '/log/';
        parent::$cache = false;
    }

    public function destroy()
    {
        if (empty(parent::$router)) {
            throw new Exception('Router Not Found!');
        }
        $getlogging = parent::$API->comm("/system/logging/print", [
            "?prefix" => "->",
        ]);
        if (count($getlogging) > 0) {
            $logging = $getlogging[0];
            if ($logging['prefix'] == "->") {
            } else {
                parent::$API->comm("/system/logging/add", [
                    "action" => "disk",
                    "prefix" => "->",
                    "topics" => "hotspot,info,debug",
                ]);
            }
        }
        $files0 = parent::$API->comm('/file/print', [
            '?name' => 'log.0.txt',
        ]);
        $files1 = parent::$API->comm('/file/print', [
            '?name' => 'log.1.txt',
        ]);
        $files = array_merge($files0, $files1);
        $ids = array_map(function ($item) {
            return $item['.id'];
        }, $files ?? []);
        $data = parent::$API->comm('/file/remove', ['.id'   => implode(',', $ids)]);
        $data = parent::$API->comm('/system/logging/action/set', [
            'numbers'       => '0,1,2,3',
            'memory-lines'  => 1
        ]);
        $data = parent::$API->comm('/system/logging/action/set', [
            'numbers'       => '0,1,2,3',
            'memory-lines'  => 1000
        ]);
        return  parent::cek_error($data);
    }
}
