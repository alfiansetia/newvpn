<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['router.exists']);
    }

    public function index()
    {
        return view('mikapi.map.index');
    }
}
