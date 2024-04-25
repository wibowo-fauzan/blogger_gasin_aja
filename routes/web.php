<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserHomeScreenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserHomeScreenController::class, 'index'])->name('indexhome');

// Grup rute untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// Grup rute untuk pengguna yang telah login
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserHomeScreenController::class, 'index'])->name('user.dashboard');
});

// Rute untuk profile, membutuhkan otentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk otentikasi, menggunakan `auth.php`
require __DIR__ . '/auth.php';

// Rute untuk verifikasi email
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
