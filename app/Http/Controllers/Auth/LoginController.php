<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', 'recaptcha']
        ], [
            'g-recaptcha-response.required' => 'Captcha Required!',
            'g-recaptcha-response.recaptcha' => 'Captcha Invalid!'
        ]);
    }

    function authenticated(Request $request, $user)
    {
        $currentIP = $request->header('CF-Connecting-IP') ?? $request->getClientIp();
        $userAgent = $request->userAgent();
        if ($user->last_login_ip != $currentIP) {
            $user->sendEmailNewLogin($currentIP, $userAgent);
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $currentIP
            ]);
        }
    }
}
