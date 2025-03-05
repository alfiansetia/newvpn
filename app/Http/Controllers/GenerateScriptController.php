<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateScriptController extends Controller
{

    public function speed_test()
    {
        return view('generate.speed_test');
    }

    public function isolir()
    {
        return view('generate.isolir');
    }
}
