<?php

namespace App\Http\Controllers\Api\Mikapi\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mikapi\System\UserActiveResource;
use App\Services\Mikapi\System\UserActiveServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserActiveController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('router.exists');
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['name']);
            $data = UserActiveServices::routerId($request->router)->get($filters);
            return DataTables::collection($data)->setTransformer(function ($item) {
                return UserActiveResource::make($item)->resolve();
            })->toJson();
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $data = UserActiveServices::routerId($request->router)->show($id);
            return new UserActiveResource($data);
        } catch (\Throwable $th) {
            return $this->send_error('Error : ' . $th->getMessage());
        }
    }
}
