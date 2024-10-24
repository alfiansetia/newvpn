<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

final class WhatsappService
{
    protected static $base_url;
    protected static $token;
    protected static $to;
    protected static $message;

    public function __construct()
    {
        self::$base_url = config('whatsapp.base_url');
        self::$token = config('whatsapp.token');
    }

    public static function token(string $token)
    {
        self::$token = $token;
        return new self;
    }

    public static function to(string $number)
    {
        self::$to = $number;
        return new self;
    }

    public static function message(string $message)
    {
        self::$message = $message;
        return new self;
    }

    public static function sendToGroup()
    {
        self::$to = config('whatsapp.group_id');
        return self::send();
    }

    public static function sendToAdmin()
    {
        self::$to = config('whatsapp.admin_id');
        return self::send();
    }

    public static function send()
    {
        if (empty(self::$token)) {
            throw new Exception('Token Not Found!');
        }

        if (empty(self::$to)) {
            throw new Exception('Recipient number must be set!');
        }

        if (empty(self::$message)) {
            throw new Exception('Message must be set!');
        }

        return Http::withHeaders([
            'Authorization' => self::$token,
        ])->post(self::$base_url, [
            'message'   => self::$message,
            'target'    => self::$to,
        ])->json();
    }
}
