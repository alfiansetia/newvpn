<?php

namespace App\Services;

use App\Models\Port;
use Exception;
use RouterOS\Query;

class PortServices extends ServerServices
{

    public function store(Port $port)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $response = self::$client;
        $query = (new Query('/ip/firewall/nat/print'))
            ->where("comment", $port->vpn->username)
            ->where("to-addresses", $port->vpn->ip)
            ->where("dst-port", $port->dst)
            ->where("to-ports", $port->to)
            ->where('disabled', 'no');
        $data = $response->query($query)->read();
        cek_exists($data);
        $queryAdd = (new Query('/ip/firewall/nat/add'))
            ->equal('chain', 'dstnat')
            ->equal('action', 'dst-nat')
            ->equal('to-addresses', $port->vpn->ip)
            ->equal('to-ports', $port->to)
            ->equal('protocol', 'tcp')
            ->equal('dst-port', $port->dst)
            ->equal('disabled', 'no')
            ->equal('comment', $port->vpn->username);
        $response->query($queryAdd)->read();
        return true;
    }

    public function update(array $old, Port $new)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $response = self::$client;
        $query = (new Query('/ip/firewall/nat/print'))
            ->where("comment", $old['vpn']['username'])
            ->where("to-addresses", $old['vpn']['ip'])
            ->where("dst-port", $old['dst'])
            ->where("to-ports", $old['to']);
        $data = $response->query($query)->read();
        if (empty($data)) {
            $queryAdd = (new Query('/ip/firewall/nat/add'))
                ->equal('chain', 'dstnat')
                ->equal('action', 'dst-nat')
                ->equal('to-addresses', $old['vpn']['ip'])
                ->equal('to-ports', $new->to)
                ->equal('protocol', 'tcp')
                ->equal('dst-port', $new->dst)
                ->equal('disabled', 'no')
                ->equal('comment', $old['vpn']['username']);
            $response->query($queryAdd)->read();
        } else {
            $firstItem = $data[0];
            $queryUpdate = (new Query('/ip/firewall/nat/set'))
                ->equal('.id', $firstItem['.id'])
                ->equal('dst-port', $new->dst)
                ->equal('to-ports', $new->to)
                ->equal('disabled', 'no');
            $response->query($queryUpdate)->read();
            $idsToRemove = array_column(array_slice($data, 1), '.id');
            if (!empty($idsToRemove)) {
                $queryRemove = (new Query('/ip/firewall/nat/remove'))
                    ->equal('.id', implode(',', $idsToRemove));
                $response->query($queryRemove)->read();
            }
        }
        return true;
    }

    public function destroy(Port $port)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $response = self::$client;
        $query = (new Query('/ip/firewall/nat/print'))
            ->where("comment", $port->vpn->username)
            ->where("to-addresses", $port->vpn->ip)
            ->where("dst-port", $port->dst)
            ->where("to-ports", $port->to)
            ->where('disabled', 'no');
        $data = $response->query($query)->read();
        if (!empty($data)) {
            $idString = implode(',', array_column($data, '.id'));
            $queryRemove = (new Query('/ip/firewall/nat/remove'))
                ->equal('.id', $idString);
            $response->query($queryRemove)->read();
        }
        return true;
    }
}
