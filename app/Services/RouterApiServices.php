<?php

namespace App\Services;

use App\Models\Router;
use App\RouterOs\RouterosAPI;
use Exception;

class RouterApiServices
{
    protected static $router;
    protected static $API;
    protected static $command;
    protected static $name;
    protected static $path;
    protected static $cache;
    protected static $user_id;

    public function __construct() {}


    public static function router(Router $router)
    {
        $router = self::cek_available($router);
        self::$router = $router;
        $ip = $router->port->vpn->server->ip;
        $port = $router->port->dst;
        $ip = $router->port->vpn->server->ip . ':' . $port;
        $user = $router->username;
        try {
            $pass = decrypt($router->password);
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
    }
    public static function get_router()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        return self::$router;
    }

    private static function cek_available(Router $router)
    {
        if (!$router->port) {
            throw new Exception('Port Not Found on Router!');
        }
        if (!$router->port->vpn->server->is_active) {
            throw new Exception('Server OFF! Contact Admin!');
        }
        if (!$router->port->vpn->is_active || $router->port->vpn->is_expired()) {
            throw new Exception('Vpn Not Active/Expired!');
        }
        return $router;
    }

    public static function ping()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        return self::$router;
    }

    public static function reboot()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = self::$API->comm('/system/reboot');
        return self::cek_error($data);
    }

    public static function shutdown()
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = self::$API->comm('/system/shutdown');
        return self::cek_error($data);
    }

    public static function routerId(string $id, $user_id = null)
    {
        static::$user_id = $user_id;
        $router = self::cek_exist($id);
        self::router($router);
        return new static;
    }


    public static function cek_exist(string $id)
    {
        $user_id = auth()->id();
        // if (empty(static::$user_id)) {
        //     $user_id = auth()->id();
        // } else {
        //     $user_id = static::$user_id;
        // }
        $router = Router::query()->where('user_id', $user_id)
            ->with(['port', 'user', 'port.vpn.server'])->find($id);
        if (!$router) {
            throw new Exception('Router Not Found!');
        }
        return $router;
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
        $message = 'Router Not Connect : ' . $api->error_str;
        throw new Exception($message);
    }
}
