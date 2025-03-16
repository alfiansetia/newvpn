<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use App\Services\TripayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TripayController extends Controller
{
    public function callback(Request $request)
    {
        $privateKey = TripayServices::get_private_key();
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);
        if ($signature !== (string) $callbackSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature',
            ]);
        }
        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return response()->json([
                'success' => false,
                'message' => 'Unrecognized callback event, no action was taken',
            ]);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data sent by tripay',
            ]);
        }
        $topup_number = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);
        if ($data->is_closed_payment === 1) {
            $topup = Topup::where('number', $topup_number)
                ->where('reference', $tripayReference)
                ->where('status', 'pending')
                ->first();
            if (!$topup) {
                return response()->json([
                    'success' => false,
                    'message' => 'No invoice found or already paid: ' . $topup_number,
                ]);
            }
            switch ($status) {
                case 'PAID':
                    $desc = $topup->desc . ' ' . $data->note;
                    $topup->update([
                        'status'            => 'done',
                        'callback_status'   => $status,
                        'paid_at'           => Carbon::createFromTimestamp($data->paid_at)->format('Y-m-d H:i:s'),
                        'desc'              => $desc
                    ]);
                    $topup->send_notif();
                    $topup->transaction_in();
                    $topup->user->plus_balance($topup->amount, 'Topup ' . $topup->number);
                    break;
                case 'EXPIRED':
                    $topup->update([
                        'status'            => 'cancel',
                        'callback_status'   => $status,
                    ]);
                    break;
                case 'FAILED':
                    $topup->update([
                        'status'            => 'cancel',
                        'callback_status'   => $status,
                    ]);
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }
            return response()->json(['success' => true]);
        }
    }
}
