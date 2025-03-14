<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\CustomerResource;
use App\Http\Resources\Mikapi\PPP\ActiveResource;
use App\Models\Mikapi\Customer;
use App\Services\Mikapi\PPP\ActiveServices;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $router_id = $request->router;
        $active_ppp = [];
        $new_data = [];
        try {
            $active_ppp = ActiveServices::routerId($router_id)->get();
        } catch (\Throwable $th) {
        }
        $data = Customer::query()->with(['odp', 'package'])
            ->filter([
                'user_id'   => $user_id,
                'router_id' => $router_id
            ])->get();

        if (empty($active_ppp)) {
            foreach ($data as $customer) {
                $customer->router_active = false;
                $customer->router_uptime = '0s';
                $new_data[] = $customer;
            }
        } else {
            $new_active = ActiveResource::collection($active_ppp)->toArray($request);
            foreach ($data as $customer) {
                $matchedPpp = collect($new_active)->first(function ($ppp) use ($customer) {
                    if (empty($ppp['name']) && empty($ppp['address'])) {
                        return false;
                    }
                    return (!empty($ppp['name']) && $ppp['name'] === $customer->secret_username) ||
                        (!empty($ppp['address']) && ($ppp['address']) === $customer->ip)
                        || (!empty($ppp['caller-id']) && ($ppp['caller-id']) === $customer->mac);
                });
                $customer->router_active = !is_null($matchedPpp);
                $customer->router_uptime = dtm_new($matchedPpp['uptime'] ?? '0s');
                $new_data[] = $customer;
            }
        }

        return CustomerResource::collection($new_data);
    }
}
