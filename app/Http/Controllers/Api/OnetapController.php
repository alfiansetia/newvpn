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
        if (!$user->email) {
            return redirect()->route('login');
        }
        $user_exist = User::where('email', $user->email)->first();

        if ($user_exist) {
            $user_exist->update(['status' => 'active']);
            $user_exist->markEmailAsVerified();
            \auth()->login($user_exist, true);
            return redirect()->route('home');
        } else {
            $new_user = User::Create([
                'email'     => $user->email,
                'name'      => $user->name,
                'password'  => 0,
                'role'      => 'user',
                'status'    => 'active',
            ]);
            $new_user->markEmailAsVerified();
            \auth()->login($new_user, true);
            return redirect()->route('home');
        }
    }
}
