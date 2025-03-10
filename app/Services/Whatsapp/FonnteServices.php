<?php

namespace App\Services\Whatsapp;

use App\Models\Server;
use App\Models\WhatsappToken;
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

    public static function test(WhatsappToken $token)
    {
        $message = 'This is test connection from ' . config('app.name');
        $user_phone = $token->user->phone;
        if (!$user_phone) {
            throw new Exception('Your Phone Whatsapp Not Valid!');
        }
        return static::send_message($token->value, $user_phone, $message);
    }

    public static function send_message($token, $target, $message)
    {
        $req = Http::withHeaders([
            'Authorization' => $token,
            'accept' => 'application/json',
        ])->post('https://api.fonnte.com/send', [
            'message'   => $message,
            'target'    => $target,
        ]);
        if (!$req->successful()) {
            $req->throw();
        } else {
            $json = $req->json();
            if (!$json['status']) {
                throw new Exception($json['reason'] ?? 'Device Not Connect!');
            }
            return $json;
        }
    }
}
