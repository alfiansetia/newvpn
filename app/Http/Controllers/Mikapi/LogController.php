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
        return view('mikapi.log.all.index');
    }


    public function hotspot()
    {
        return view('mikapi.log.hotspot.index');
    }

    public function user()
    {
        return view('mikapi.log.user.index');
    }
}
