<?php

namespace App\Http\Controllers\Api\Mikapi;

use App\Http\Controllers\Controller;
use App\Services\Mikapi\DashboardServices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function get(Request $request)
    {
        try {
            $services = DashboardServices::routerId($request->router);
            $data = $services->get();
            // $router = $services->get_router();
            // $router->destroy_cache();
            return $this->send_response('', $data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
