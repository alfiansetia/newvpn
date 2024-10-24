<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index(Request $request)
    {
        return view('port.index');
    }
}
