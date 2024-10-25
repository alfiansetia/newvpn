<?php

namespace App\Http\Controllers;

use App\Traits\CompanyTrait;

class ProfileController extends Controller
{
    use CompanyTrait;

    public function profile()
    {
        return view('setting.profile');
    }

    public function profileEdit()
    {
        return view('setting.profile_edit');
    }
}
