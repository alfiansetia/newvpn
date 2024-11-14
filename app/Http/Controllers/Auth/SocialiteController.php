<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function onetap(Request $request)
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

    public function redirectToProvider(string $provider = 'google')
    {
        if ($provider == 'facebook') {
            return Socialite::driver('facebook')->redirect();
        } else {
            return Socialite::driver('google')->redirect();
        }
    }

    public function handleProviderCallback(string $provider = 'google')
    {
        try {
            if ($provider == 'facebook') {
                $user_provider = Socialite::driver('facebook')->user();
            } else {
                $user_provider = Socialite::driver('google')->user();
            }
            $user = User::where('email', $user_provider->getEmail())->first();
            if ($user != null) {
                $user->update(['status' => 'active']);
                $user->markEmailAsVerified();
                \auth()->login($user, true);
                return redirect()->route('home');
            } else {
                $create = User::Create([
                    'email'     => $user_provider->getEmail(),
                    'name'      => $user_provider->getName(),
                    'password'  => 0,
                    'role'      => 'user',
                    'status'    => 'active',
                ]);
                $create->markEmailAsVerified();
                \auth()->login($create, true);
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}
