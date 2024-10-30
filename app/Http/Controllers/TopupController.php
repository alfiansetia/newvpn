<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopupController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user->is_admin()) {
            return view('topup.index');
        } else {
            return view('topup.index_user');
        }
    }
}
