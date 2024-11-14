<?php

namespace App\Services;

use App\Models\Vpn;
use Exception;
use Illuminate\Support\Carbon;

class VpnServices extends ServerServices
{

    public function show(Vpn $vpn)
    {
        if (empty(parent::$server)) {
            throw new Exception('Server Not Found!');
        }
        $data = parent::$API->comm('/ppp/secret/print', [
            '?name' => $vpn->username
        ]);
        if (empty($data)) {
            throw new Exception('Data Not Found!');
        }
        return $data[0];
    }

    public function store(Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $server = self::$server;
        $vpn->load('ports');
        $expired = strtolower(Carbon::parse($vpn->expired)->format('M/d/Y'));
        $data = parent::$API->comm('/ppp/secret/print', [
            '?name' => $vpn->username
        ]);
        parent::cek_error($data);
        parent::cek_exists($data);

        $data = parent::$API->comm('/ppp/secret/add', [
            'service'           => 'any',
            'name'              => $vpn->username,
            'password'          => $vpn->password,
            'local-address'     => $server->netwatch,
            'remote-address'    => $vpn->ip,
            'disabled'          => $vpn->is_active ? 'no' : 'yes',
            'comment'           => $expired,
        ]);

        foreach ($vpn->ports ?? [] as $item) {
            $data = parent::$API->comm('/ip/firewall/nat/add', [
                'chain'         => 'dstnat',
                'action'        => 'dst-nat',
                'to-addresses'  => $vpn->ip,
                'to-ports'      => $item->to,
                'protocol'      => 'tcp',
                'dst-port'      => $item->dst,
                'disabled'      => 'no',
                'comment'       => $vpn->username,
            ]);
        }
        return true;
    }

    public function update(array $old, Vpn $vpn)
    {
        if (empty(parent::$server)) {
            throw new Exception('Server Not Found!');
        }
        $server = parent::$server;
        $vpn->load('ports');
        $expired = strtolower(Carbon::parse($vpn->expired)->format('M/d/Y'));
        $data = parent::$API->comm('/ppp/secret/print', [
            '?name' => $old['username']
        ]);

        if (empty($data)) {
            $data_add = parent::$API->comm('/ppp/secret/add', [
                'service'           => 'any',
                'name'              => $vpn->username,
                'password'          => $vpn->password,
                'local-address'     => $server->netwatch,
                'remote-address'    => $vpn->ip,
                'disabled'          => $vpn->is_active ? 'no' : 'yes',
                'comment'           => $expired,
            ]);
            parent::cek_error($data_add);
        } else {
            $firstItem = $data[0];
            $data_update = parent::$API->comm('/ppp/secret/set', [
                '.id'               => $firstItem['.id'],
                'name'              => $vpn->username,
                'password'          => $vpn->password,
                'local-address'     => $server->netwatch,
                'remote-address'    => $vpn->ip,
                'disabled'          => $vpn->is_active ? 'no' : 'yes',
                'comment'           => $expired,
            ]);
            parent::cek_error($data_update);
            $idsToRemove = array_column(array_slice($data, 1), '.id');
            if (!empty($idsToRemove)) {
                $data_remove = parent::$API->comm('/ppp/secret/remove', [
                    '.id'   => implode(',', $idsToRemove)
                ]);
            }
        }
        $dataNat = parent::$API->comm('/ip/firewall/nat/print', [
            "?comment" => $old['username']
        ]);
        if (!empty($dataNat)) {
            $idStringNat = implode(',', array_column($dataNat, '.id'));
            $queryRemoveNat = parent::$API->comm('/ip/firewall/nat/remove', [
                '.id'   => $idStringNat
            ]);
        }
        foreach ($vpn->ports as $item) {
            $queryAdd = parent::$API->comm('/ip/firewall/nat/add', [
                'chain'         => 'dstnat',
                'action'        => 'dst-nat',
                'to-addresses'  => $vpn->ip,
                'to-ports'      => $item->to,
                'protocol'      => 'tcp',
                'dst-port'      => $item->dst,
                'disabled'      => 'no',
                'comment'       => $vpn->username,
            ]);
        }
        return true;
    }

    public function destroy(Vpn $vpn)
    {
        if (empty(self::$server)) {
            throw new Exception('Server Not Found!');
        }
        $vpn->load('ports');
        $data = parent::$API->comm('/ppp/secret/print', [
            "?name" => $vpn->username
        ]);
        if (!empty($data)) {
            $idString = implode(',', array_column($data, '.id'));
            $queryRemove = parent::$API->comm('/ppp/secret/remove', [
                '.id'   => $idString
            ]);
        }
        $dataActive = parent::$API->comm('/ppp/active/print', [
            "?name" => $vpn->username
        ]);
        if (!empty($dataActive)) {
            $idStringActive = implode(',', array_column($dataActive, '.id'));
            $queryRemove = parent::$API->comm('/ppp/active/remove', [
                '.id'   => $idStringActive
            ]);
        }

        $dataNat = parent::$API->comm('/ip/firewall/nat/print', [
            "?comment" => $vpn->username
        ]);
        if (!empty($dataNat)) {
            $idStringnat = implode(',', array_column($dataNat, '.id'));
            $queryRemove = parent::$API->comm('/ip/firewall/nat/remove', [
                '.id'   => $idStringnat
            ]);
        }
        return true;
    }
}
