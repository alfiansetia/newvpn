<?php

namespace App\Services;

use App\Models\Topup;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

final class TripayServices
{
    protected static $base_url;
    protected static $token;

    public function __construct()
    {
        self::$base_url = config('services.tripay.base_url');
        self::$token = config('whatsapp.token');
    }

    public static function get_api_key()
    {
        return config('services.tripay.api_key');
    }

    public static function get_base_url()
    {
        return config('services.tripay.base_url');
    }

    public static function get_private_key()
    {
        return config('services.tripay.private_key');
    }

    public static function get_merchant_code()
    {
        return config('services.tripay.merchant_code');
    }

    public static function get_signature($ref, $amount)
    {
        $merchantCode = self::get_merchant_code();
        $privateKey = self::get_private_key();
        return hash_hmac('sha256', $merchantCode  . $ref . $amount, $privateKey);
    }

    public static function fee_calculator(int $amount, $code)
    {
        $token = self::get_api_key();
        $base_url = self::get_base_url();
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("$base_url/merchant/fee-calculator", [
            'amount'   => $amount,
            'code'    => $code,
        ])->json();
    }

    public static function get_channel()
    {
        $token = self::get_api_key();
        $base_url = self::get_base_url();
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("$base_url/merchant/payment-channel",)->json();
    }

    public static function create(Topup $topup)
    {
        $user = $topup->user;
        $ref = $topup->number;
        $amount = $topup->amount;
        $token = self::get_api_key();
        $base_url = self::get_base_url();
        $req =  Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post("$base_url/transaction/create", [
            'method' => 'QRISC',
            'merchant_ref' => $ref,
            'amount' => $amount,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'signature' => self::get_signature($ref, $amount),
            'order_items' => [
                [
                    'name' => 'Payment Topup ' . $ref,
                    'price' => $amount,
                    'quantity' => 1,
                    'subtotal' => $amount,
                ]
            ],
        ]);
        $json = $req->json();
        if ($req->successful() && $json['success']) {
            return $json['data'];
        } else {
            throw new Exception('Error Creating Data : ' . $json['message']);
        }
    }
}
