<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Periksa apakah pengguna memiliki peran yang diperlukan
        if (!$user || !in_array($user->role, $roles)) {
            // Jika tidak, redirect ke beranda atau halaman lain
            return redirect('/')->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}
