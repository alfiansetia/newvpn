<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemporaryIpController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('temp.index');
    }
}
