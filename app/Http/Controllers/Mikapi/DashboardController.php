<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['router.exists']);
    }

    public function index(Request $request)
    {
        return view('mikapi.dashboard');
    }
}
