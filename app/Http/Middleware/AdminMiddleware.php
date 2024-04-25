<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna adalah admin
        if (auth()->user() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, redirect ke beranda
        return redirect('/');
    }
}