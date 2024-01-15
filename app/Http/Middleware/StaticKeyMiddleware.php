<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaticKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $staticKey =  $request->header('static_key_api');
        $staticKeyEnv = env('STATIC_KEY_API', '');

        if(!isset($staticKey) || $staticKey !== $staticKeyEnv) {
            return response()->json(['status' => false, 'message' => 'Unautorized'], 401);
        }

        return $next($request);

    }
}
