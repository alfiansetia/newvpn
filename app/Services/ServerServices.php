<?php

namespace App\Services;

use App\Models\Server;
use Exception;
use RouterOS\Client;
use RouterOS\Query;

class ServerServices
{
    protected static $client;
    protected static $server;

    public function __construct() {}

    public static function server(Server $server)
    {
        self::$server = $server;
        if (!$server->is_active) {
            throw new Exception('Server Nonactive!');
        }
        try {
            $pass = decrypt($server->password);
        } catch (\Throwable $th) {
            $pass = '';
        }
        $config = new \RouterOS\Config([
            'host'      => $server->ip,
            'user'      => $server->username,
            'pass'      => $pass,
            'port'      => $server->port,
            'timeout'   => 2,
            'attempts'  => 1,
        ]);
        self::$client = new Client($config);
        return new static;
    }

    public function ping()
    {
        if (empty(self::$client)) {
            throw new Exception('Server Not Found!');
        }
        return self::$client;
    }

    public function get()
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $query = (new Query('/ip/hotspot/user/print'));
        $response = self::$client->query($query)->read();
        return $response;
    }
}
