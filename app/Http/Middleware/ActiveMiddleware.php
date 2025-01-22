<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user->is_verified() || !$user->is_active()) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => 'Your account is Nonactive!'], 403);
            }
            return redirect()->route('home')->with('error', 'Your account is Nonactive, Contact Admin!');
        }
        $phoneRegex = '/^\+?[0-9#_]{7,15}$/';
        if (!preg_match($phoneRegex, $user->phone) || empty($user->phone)) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => 'Complete your profile info!'], 403);
            }
            return redirect()->route('setting.profile.edit')->with('error', 'Lengkapi Profile Anda dengan Nomor Whatsapp yang valid!');
        }
        return $next($request);
    }
}
