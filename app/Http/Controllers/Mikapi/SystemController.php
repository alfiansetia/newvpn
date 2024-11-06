<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('router.exists');
    }

    public function index()
    {
        return view('mikapi.system.system.index');
    }

    public function user()
    {
        return view('mikapi.system.user.index');
    }

    public function group()
    {
        return view('mikapi.system.group.index');
    }

    public function user_active()
    {
        return view('mikapi.system.user_active.index');
    }
}
