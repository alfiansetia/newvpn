<?php

namespace App\Http\Controllers;

use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingController extends Controller
{
    use CompanyTrait;

    private $base_url_telegram = 'https://api.telegram.org/';

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function telegram()
    {
        $setting = $this->getSetting();
        return view('setting.company.telegram', compact(['setting']));
    }

    public function telegramUpdate(Request $request)
    {
        $this->validate($request, [
            'telegram_token'    => 'required',
            'telegram_bot_name' => 'required',
            'telegram_group_id' => 'required',
        ]);
        $setting = $this->getSetting();
        $setting->update([
            'telegram_token'    => $request->telegram_token,
            'telegram_bot_name' => $request->telegram_bot_name,
            'telegram_group_id' => $request->telegram_group_id,
        ]);
        return $this->send_response('Success Update Telegram!');
    }

    public function telegramSet(Request $request)
    {
        $this->validate($request, [
            'action'    => 'required|in:set,unset,info',
        ]);
        $setting = $this->getSetting();
        $botToken = $setting->telegram_token;
        if ($request->action === 'info') {
            return $this->getInfoWebhook($botToken);
        } elseif ($request->action === 'set') {
            return $this->setWebhook($botToken);
        } elseif ($request->action === 'unset') {
            return $this->unSetWebhook($botToken);
        }
    }

    private function setWebhook(string $token)
    {
        $url_webhook = url("api/telegram/$token/webhook");
        $url = $this->base_url_telegram . "bot{$token}/setWebhook?url=$url_webhook";
        return $this->handle($url);
    }

    private function unSetWebhook(string $token)
    {
        $url = $this->base_url_telegram . "bot{$token}/deleteWebhook";
        return $this->handle($url);
    }

    private function getInfoWebhook(string $token)
    {
        $url = $this->base_url_telegram . "bot{$token}/getWebhookInfo";
        return $this->handle($url);
    }

    private function handle($url)
    {
        try {
            $response = Http::get($url);
            $json = $response->json();
            $message = 'Success!';
            $error = 'Undefined!';
            if (isset($json['description'])) {
                $message = 'Success : ' . $json['description'] . '!';
                $error = $json['description'] . '!';
            }
            if ($response->successful() && !empty($json)) {
                return $this->send_response($message, $json);
            } else {
                return $this->send_error('Error get Webhook Info : ' . $error, $json);
            }
        } catch (\Exception $e) {
            return $this->send_error('Error : ' . $e->getMessage());
        }
    }
}
