<?php

namespace App\Services;

use App\Models\Router;
use Exception;
use RouterOS\Client;
use RouterOS\Query;

class RouterServices
{
    protected static $router;
    protected static $client;
    protected static $command;
    protected static $name;
    protected static $path;
    protected static $cache;

    public function __construct() {}

    public static function router(Router $router)
    {
        self::$router = $router;
        $ip = $router->port->vpn->server->ip;
        $user = $router->username;
        $port = $router->port->dst;
        try {
            $pass = decrypt($router->password);
        } catch (\Throwable $th) {
            $pass = '';
        }
        $router = self::cek_available($router);
        $config = new \RouterOS\Config([
            'host'      => $ip,
            'user'      => $user,
            'pass'      => $pass,
            'port'      => $port,
            // 'timeout'   => 2,
            // 'attempts'  => 1,
        ]);
        self::$client = new Client($config);
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
}
