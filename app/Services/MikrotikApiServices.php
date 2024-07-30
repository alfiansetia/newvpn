<?php

namespace App\Services;

use App\Models\Router;
use App\RouterOs\RouterosAPI;
use Exception;

class MikrotikApiServices
{
    protected $router;
    protected $API;
    protected $ip;
    protected $port;
    protected $user;
    protected $pass;
    protected $command = '';
    protected array $param = [];

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->API = new RouterosAPI();
        $this->API->debug = false;
        $this->API->timeout = 2;
        $this->API->attempts = 1;
        $this->router($router);
    }

    protected function router(Router $router)
    {
        $ip = $router->port->vpn->server->ip;
        $port = $router->port->dst;

        $user = $router->username;
        try {
            $pass = decrypt($this->router->password);
        } catch (\Throwable $th) {
            $pass = '';
        }
        $this->ip = $ip;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        return $this;
    }

    public function param(array $param)
    {
        $this->param = $param;
        return $this;
    }

    public function command(string $command)
    {
        $this->command = $command;
        return $this;
    }

    protected function get()
    {
        if ($this->API->connect(($this->ip . ":" . $this->port), $this->user,  $this->pass)) {
            return $this->API->comm($this->command, $this->param);
        } else {
            return handle_fail_login($this->API);
        };
    }

    protected function disconnect()
    {
        return $this->API->disconnect();
    }
}
