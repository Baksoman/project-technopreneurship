<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('auth')->with('error', 'Silakan login terlebih dahulu.');
        }

        session(['last_activity_time' => time()]);

        return $next($request);
    }
}
