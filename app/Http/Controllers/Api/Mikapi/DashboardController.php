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
            $data = DashboardServices::routerId($request->router)->get();
            return $this->send_response('', $data);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
