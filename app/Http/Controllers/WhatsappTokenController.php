<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappTokenController extends Controller
{
    public function index(Request $request)
    {
        return view('wa_token.index');
    }
}
