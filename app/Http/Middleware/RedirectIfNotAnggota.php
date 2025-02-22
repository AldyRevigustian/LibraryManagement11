<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAnggota
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('anggota')->check()) {
            return redirect()->route('anggota.login');
        }
        return $next($request);
    }
}
