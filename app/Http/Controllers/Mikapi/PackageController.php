<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use App\Models\Mikapi\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['router.exists']);
    }

    public function index()
    {
        return view('mikapi.package.index');
    }
}
