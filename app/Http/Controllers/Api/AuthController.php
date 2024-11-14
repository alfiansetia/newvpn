<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->send_response_unauthenticate('User & Password Wrong');
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->getClientIp()
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->send_response('Hi ' . $user->name . ', welcome to home', [
            'token'     => $token,
            'user'      => new UserResource($user),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->send_response('You have successfully logged out and the token was successfully deleted');
    }
}
