<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Jika pengguna adalah admin, tampilkan tampilan khusus admin
            return view('auth.verify-email');
        }

        // Jika pengguna adalah user biasa, tampilkan tampilan dasar
        return view('auth.verify-email');
    }
}