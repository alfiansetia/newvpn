<?php

namespace App\Services;

use App\Models\Router;
use Exception;
use RouterOS\Client;
use RouterOS\Query;

final class RouterServices
{
    protected static $router;
    protected static $client;

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
            'timeout'   => 2,
            'attempts'  => 1,
        ]);
        self::$client = new Client($config);
        return new static;
    }

    private static function cek_available(Router $router)
    {
        if (!$router->port) {
            throw new Exception('Select VPN on Router!');
        }
        if (!$router->port->vpn->is_active) {
            throw new Exception('Your VPN Nonactive!');
        }
        if (!$router->port->vpn->server->is_active) {
            throw new Exception('Server OFF! Contact Admin!');
        }
        return $router;
    }

    public function ping()
    {
        if (empty(self::$client)) {
            throw new Exception('Router Not Found!');
        }
        return self::$client->read();
    }
}
