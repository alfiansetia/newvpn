<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterExistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->filled('router')) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => "Invalid Selected Router!",], 403);
            }
            return redirect()->route('routers.index')->with('error', 'Router Required!');
        }
        return $next($request);
    }
}
