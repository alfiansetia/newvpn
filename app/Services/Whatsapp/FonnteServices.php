<?php

namespace App\Services\Whatsapp;

use App\Models\Server;
use Exception;
use Illuminate\Support\Facades\Http;

class FonnteServices
{
    protected static $server;

    public function __construct() {}

    public static function get_all_user_devices($user_token)
    {
        $req = Http::withHeaders([
            'Authorization' => $user_token,
            'accept' => 'application/json',
        ])->post('https://api.fonnte.com/get-devices', []);
        if (!$req->successful()) {
            $req->throw();
        } else {
            $json = $req->json();
            if (!$json['status']) {
                throw new Exception('User Token Invalid!');
            }
            return $json;
        }
    }

    public static function detail_device($device_token)
    {
        $req = Http::withHeaders([
            'Authorization' => $device_token,
            'accept' => 'application/json',
        ])->post('https://api.fonnte.com/device', []);
        if (!$req->successful()) {
            $req->throw();
        } else {
            $json = $req->json();
            if (!$json['status']) {
                return null;
            }
            return $json;
        }
    }

    private static function cek_available(Server $server)
    {
        if (!$server->is_active) {
            throw new Exception('Server Nonactive!');
        }
        return $server;
    }

    public static function cek_error($api)
    {
        if (isset($api['!trap'])) {
            throw new Exception('Error : ' . $api['!trap'][0]['message']);
        }
        return $api;
    }
}
