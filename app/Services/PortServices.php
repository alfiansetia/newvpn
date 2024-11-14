<?php

namespace App\Services;

use App\Models\Port;
use Exception;

class PortServices extends ServerServices
{

    public function store(Port $port)
    {
        if (empty(parent::$server)) {
            throw new Exception('Server Not Found!');
        }
        $data = parent::$API->comm('/ip/firewall/nat/print', [
            "?comment"      => $port->vpn->username,
            "?to-addresses" => $port->vpn->ip,
            "?dst-port"     => $port->dst,
            "?to-ports"     => $port->to,
            '?disabled'     => 'no',
        ]);
        parent::cek_exists($data);
        $dataAdd = parent::$API->comm('/ip/firewall/nat/add', [
            'chain'         => 'dstnat',
            'action'        => 'dst-nat',
            'to-addresses'  => $port->vpn->ip,
            'to-ports'      => $port->to,
            'protocol'      => 'tcp',
            'dst-port'      => $port->dst,
            'disabled'      => 'no',
            'comment'       => $port->vpn->username,
        ]);
        parent::cek_error($dataAdd);
        return true;
    }

    public function update(array $old, Port $new)
    {
        if (empty(parent::$server)) {
            throw new Exception('Server Not Found!');
        }
        $data = parent::$API->comm('/ip/firewall/nat/print', [
            "?comment"      => $old['vpn']['username'],
            "?to-addresses" => $old['vpn']['ip'],
            "?dst-port"     => $old['dst'],
            "?to-ports"     => $old['to'],
        ]);

        if (empty($data)) {
            $queryAdd = parent::$API->comm('/ip/firewall/nat/add', [
                'chain'         => 'dstnat',
                'action'        => 'dst-nat',
                'to-addresses'  => $old['vpn']['ip'],
                'to-ports'      => $new->to,
                'protocol'      => 'tcp',
                'dst-port'      => $new->dst,
                'disabled'      => 'no',
                'comment'       => $old['vpn']['username'],
            ]);
            parent::cek_error($queryAdd);
        } else {
            $firstItem = $data[0];
            $queryUpdate = parent::$API->comm('/ip/firewall/nat/set', [
                '.id'       => $firstItem['.id'],
                'dst-port'  => $new->dst,
                'to-ports'  => $new->to,
                'disabled'  => 'no',
            ]);
            $idsToRemove = array_column(array_slice($data, 1), '.id');
            if (!empty($idsToRemove)) {
                $queryRemove = parent::$API->comm('/ip/firewall/nat/remove', [
                    '.id'   => implode(',', $idsToRemove)
                ]);
            }
        }
        return true;
    }

    public function destroy(Port $port)
    {
        if (empty(parent::$server)) {
            throw new Exception('Server Not Found!');
        }
        $data = parent::$API->comm('/ip/firewall/nat/print', [
            "?comment"       => $port->vpn->username,
            "?to-addresses"  => $port->vpn->ip,
            "?dst-port"      => $port->dst,
            "?to-ports"      => $port->to,
            '?disabled'      => 'no',
        ]);
        parent::cek_error($data);
        if (!empty($data)) {
            $idString = implode(',', array_column($data, '.id'));
            $queryRemove = parent::$API->comm('/ip/firewall/nat/remove', [
                '.id'   => $idString
            ]);
        }
        return true;
    }
}
