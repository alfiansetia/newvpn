<?php

namespace App\Http\Controllers;

use App\Models\Vpn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VpnController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->is_admin()) {
            return view('vpn.index');
        } else {
            return view('vpn.index_user');
        }
    }

    public function create(Request $request)
    {
        return view('vpn.create_auto');
    }
}
