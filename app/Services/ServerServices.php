<?php

namespace App\Services;

use App\Models\Server;
use App\RouterOs\RouterosAPI;
use Exception;

class ServerServices
{
    protected static $server;
    protected static $API;

    public function __construct() {}

    public static function server(Server $server)
    {
        $server = self::cek_available($server);
        self::$server = $server;
        $ip = $server->ip;
        $port = $server->port;
        $ip = $server->ip . ':' . $port;
        $user = $server->username;
        try {
            $pass = decrypt($server->password);
        } catch (\Throwable $th) {
            $pass = '';
        }
        $api = new RouterosAPI();
        $api->debug = false;
        $api->timeout = 2;
        $api->attempts = 1;
        if ($api->connect($ip, $user, $pass)) {
            self::$API = $api;
            return new static;
        } else {
            self::fail_login($api);
        }
        return new static;
    }

    public function ping()
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        return self::$server;
    }

    private static function cek_available(Server $server)
    {
        if (!$server->is_active) {
            throw new Exception('Server Nonactive!');
        }
        // if (!$server->is_available) {
        //     throw new Exception('Server Unavailable!');
        // }
        return $server;
    }

    public static function cek_error($api)
    {
        if (isset($api['!trap'])) {
            throw new Exception('Error : ' . $api['!trap'][0]['message']);
        }
        return $api;
    }

    public static function fail_login($api)
    {
        if ($api->error_str == "") {
            $api->error_str = "User/Password Wrong!";
        }
        $message = 'Server Not Connect : ' . $api->error_str;
        throw new Exception($message);
    }

    public static  function cek_exists($response)
    {
        if (count($response) > 0) {
            throw new Exception('Data Already Exist!');
        }
    }
}
