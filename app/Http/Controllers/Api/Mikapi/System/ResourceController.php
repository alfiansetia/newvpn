<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\ResourceResource;
use App\Services\Mikapi\System\ResourceServices;
use App\Traits\RouterTrait;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    use RouterTrait;

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $this->setRouter($request->router, ResourceServices::class);
            $query = [];
            $data = $this->conn->get($query);
            return ResourceResource::collection($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function settings(Request $request)
    {
        try {
            $this->setRouter($request->router, ResourceServices::class);
            $query = [];
            $data = $this->conn->settings($query);
            return ResourceResource::collection($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
