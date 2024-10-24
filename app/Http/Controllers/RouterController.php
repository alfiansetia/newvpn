<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index(Request $request)
    {
        return view('router.index');
    }
}
