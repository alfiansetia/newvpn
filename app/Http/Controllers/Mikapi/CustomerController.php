<?php

namespace App\Http\Controllers\Mikapi;

use App\Http\Controllers\Controller;
use App\Models\Mikapi\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['router.exists']);
    }

    public function index()
    {
        return view('mikapi.customer.index');
    }
}
