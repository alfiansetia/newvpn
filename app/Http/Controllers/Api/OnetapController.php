<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OnetapController extends Controller
{
    public function login(Request $request)
    {
        $token = $request->credential;
        $tokenParts = explode('.', $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
        $user = $jwtPayload;
        // return $user;
        $user = User::where('email', $user->email)->first();

        if ($user != null) {
            $user->update(['status' => 'active']);
            $user->markEmailAsVerified();
            \auth()->login($user, true);
            return redirect()->route('home');
        } else {
            $create = User::Create([
                'email'     => $user->email,
                'name'      => $user->name,
                'password'  => 0,
                'role'      => 'user',
                'status'    => 'active',
            ]);
            $create->markEmailAsVerified();
            \auth()->login($create, true);
            return redirect()->route('home');
        }
    }
}
