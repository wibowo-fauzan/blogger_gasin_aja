<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi pengguna
        $request->authenticate();

        // Regenerasi sesi untuk keamanan
        $request->session()->regenerate();

        // Mengarahkan berdasarkan peran pengguna
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        if ($user->role === 'admin') {
            // Jika admin, diarahkan ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika bukan admin, diarahkan ke beranda
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
