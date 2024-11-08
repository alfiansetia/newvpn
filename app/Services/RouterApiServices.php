<?php

namespace App\Services;

use App\Models\Router;
use App\RouterOs\RouterosAPI;
use Exception;

class RouterApiServices
{
    protected static $router;
    protected static $API;
    protected static $client;
    protected static $command;
    protected static $name;
    protected static $path;
    protected static $cache;

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

        self::$API = new RouterosAPI();
        self::$API->debug = false;
        self::$API->timeout = 2;
        self::$API->attempts = 1;
        self::$API->connect($ip, $user, $pass);
        return new static;
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
            throw new Exception('Vpn Not Active!');
        }
        return $router;
    }

    public static function ping()
    {
        if (empty(self::$client)) {
            throw new Exception('Router Not Found!');
        }
        return self::$client;
    }

    public static function routerId(string $id)
    {
        $router = self::cek_exist($id);
        self::router($router);
        return new static;
    }


    public static function cek_exist(string $id)
    {
        $user_id = auth()->id();
        $router = Router::query()->where('user_id', $user_id)
            ->with(['port', 'user', 'port.vpn.server'])->find($id);
        if (!$router) {
            throw new Exception('Router Not Found');
        }
        return $router;
    }

    public static function cek_error($response)
    {
        if (isset($response['after'])) {
            if (isset($response['after']['message'])) {
                throw new Exception($response['after']['message']);
            }
            if (isset($response['after']['ret'])) {
                return $response['after']['ret'];
            }
        }
        return $response;
    }

    public static function get($c, array $filters = [])
    {
        if (empty(self::$router)) {
            throw new Exception('Router Not Found!');
        }
        $data = self::$API->comm($c);
        return $data;
    }


    // protected function connect()
    // {
    //     $ip = $this->router->port->vpn->server->ip . ':' . $this->router->port->dst;
    //     $user = $this->router->username;
    //     try {
    //         $pass = decrypt($this->router->password);
    //     } catch (\Throwable $th) {
    //         $pass = '';
    //     }
    //     return $this->API->connect($ip, $user, $pass);
    // }

    // protected function disconnect()
    // {
    //     return $this->API->disconnect();
    // }
}
