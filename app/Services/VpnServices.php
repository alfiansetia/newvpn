<?php

namespace App\Services;

use App\Models\Vpn;
use Exception;
use Illuminate\Support\Carbon;
use RouterOS\Query;

class VpnServices extends ServerServices
{

    public function show(Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $response = self::$client;
        $query = (new Query('/ppp/secret/print'))
            ->where("name", $vpn->username);
        $data = $response->query($query)->read();
        if (empty($data)) {
            return null;
        } else {
            return $data[0];
        }
    }

    public function store(Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $server = self::$server;
        $response = self::$client;
        $vpn->load('ports');
        $expired = strtolower(Carbon::parse($vpn->expired)->format('M/d/Y'));
        $query = (new Query('/ppp/secret/print'))
            ->where("name", $vpn->username);
        $data = $response->query($query)->read();
        cek_exists($data);
        $queryAdd = (new Query('/ppp/secret/add'))
            ->equal('service', 'any')
            ->equal('name', $vpn->username)
            ->equal('password', $vpn->password)
            ->equal('local-address', $server->netwatch)
            ->equal('remote-address', $vpn->ip)
            ->equal('disabled', $vpn->is_active ? 'no' : 'yes')
            ->equal('comment', $expired);
        $response->query($queryAdd)->read();

        foreach ($vpn->ports as $item) {
            $queryAdd = (new Query('/ip/firewall/nat/add'))
                ->equal('chain', 'dstnat')
                ->equal('action', 'dst-nat')
                ->equal('to-addresses', $vpn->ip)
                ->equal('to-ports', $item->to)
                ->equal('protocol', 'tcp')
                ->equal('dst-port', $item->dst)
                ->equal('disabled', 'no')
                ->equal('comment', $vpn->username);
            $response->query($queryAdd)->read();
        }
        return true;
    }

    public function update(array $old, Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $server = self::$server;
        $response = self::$client;
        $vpn->load('ports');
        $expired = strtolower(Carbon::parse($vpn->expired)->format('M/d/Y'));
        $query = (new Query('/ppp/secret/print'))
            ->where("name", $old['username']);
        $data = $response->query($query)->read();
        if (empty($data)) {
            $queryAdd = (new Query('/ppp/secret/add'))
                ->equal('service', 'any')
                ->equal('name', $vpn->username)
                ->equal('password', $vpn->password)
                ->equal('local-address', $server->netwatch)
                ->equal('remote-address', $vpn->ip)
                ->equal('disabled', $vpn->is_active ? 'no' : 'yes')
                ->equal('comment', $expired);
            $response->query($queryAdd)->read();
        } else {
            $firstItem = $data[0];
            $queryUpdate = (new Query('/ppp/secret/set'))
                ->equal('.id', $firstItem['.id'])
                ->equal('name', $vpn->username)
                ->equal('password', $vpn->password)
                ->equal('local-address', $server->netwatch)
                ->equal('remote-address', $vpn->ip)
                ->equal('disabled', $vpn->is_active ? 'no' : 'yes')
                ->equal('comment', $expired);
            $response->query($queryUpdate)->read();
            $idsToRemove = array_column(array_slice($data, 1), '.id');
            if (!empty($idsToRemove)) {
                $queryRemove = (new Query('/ppp/secret/remove'))
                    ->equal('.id', implode(',', $idsToRemove));
                $response->query($queryRemove)->read();
            }
        }

        $queryNat = (new Query('/ip/firewall/nat/print'))
            ->where("comment", $old['username']);
        $dataNat = $response->query($queryNat)->read();
        if (!empty($dataNat)) {
            $idStringNat = implode(',', array_column($dataNat, '.id'));
            $queryRemoveNat = (new Query('/ip/firewall/nat/remove'))
                ->equal('.id', $idStringNat);
            $response->query($queryRemoveNat)->read();
        }
        foreach ($vpn->ports as $item) {
            $queryAdd = (new Query('/ip/firewall/nat/add'))
                ->equal('chain', 'dstnat')
                ->equal('action', 'dst-nat')
                ->equal('to-addresses', $vpn->ip)
                ->equal('to-ports', $item->to)
                ->equal('protocol', 'tcp')
                ->equal('dst-port', $item->dst)
                ->equal('disabled', 'no')
                ->equal('comment', $vpn->username);
            $response->query($queryAdd)->read();
        }
        return true;
    }

    public function destroy(Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $response = self::$client;
        $vpn->load('ports');
        $query = (new Query('/ppp/secret/print'))
            ->where("name", $vpn->username);
        $data = $response->query($query)->read();
        if (!empty($data)) {
            $idString = implode(',', array_column($data, '.id'));
            $queryRemove = (new Query('/ppp/secret/remove'))
                ->equal('.id', $idString);
            $response->query($queryRemove)->read();
        }

        $queryActive = (new Query('/ppp/active/print'))
            ->where("name", $vpn->username);
        $dataActive = $response->query($queryActive)->read();
        if (!empty($dataActive)) {
            $idString = implode(',', array_column($dataActive, '.id'));
            $queryRemove = (new Query('/ppp/active/remove'))
                ->equal('.id', $idString);
            $response->query($queryRemove)->read();
        }

        $queryNat = (new Query('/ip/firewall/nat/print'))
            ->where("comment", $vpn->username);
        $dataNat = $response->query($queryNat)->read();
        if (!empty($dataNat)) {
            $idString = implode(',', array_column($dataNat, '.id'));
            $queryRemove = (new Query('/ip/firewall/nat/remove'))
                ->equal('.id', $idString);
            $response->query($queryRemove)->read();
        }
        return true;
    }
}
