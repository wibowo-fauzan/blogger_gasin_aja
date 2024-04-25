<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat pengguna baru dengan peran tertentu
        $role = 'user'; // Default role

        if ($request->email === 'admin@example.com') {
            $role = 'admin'; // Menetapkan peran admin berdasarkan logika
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Menyimpan peran dalam database
        ]);

        // Emit event setelah pendaftaran berhasil
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect berdasarkan peran
        if ($user->role === 'admin') {
            return redirect('/dashboard'); // Admin diarahkan ke dashboard
        }

        return redirect('/'); // Pengguna biasa diarahkan ke beranda
    }
}
