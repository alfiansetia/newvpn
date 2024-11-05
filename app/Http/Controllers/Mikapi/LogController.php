<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('router.exists');
    }

    public function index()
    {
        return view('mikapi.log.index');
    }
}
