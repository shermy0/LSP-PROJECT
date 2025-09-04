<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;

Route::get('/', function () {
    return view('welcome'); // ini default home Laravel
})->name('home');

// login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// pilih role register
Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

// register asesi
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

// register asesor
Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

// Form Perencanaan untuk Asesor
Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');

// === Dashboard Routes ===
Route::middleware(['auth'])->group(function () {
    // index dashboard (auto redirect sesuai role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // admin
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');
        

    // asesi
    Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])
        ->name('dashboard.asesi');
       

    // asesor
    Route::get('/dashboard/asesor', [DashboardController::class, 'asesor'])
        ->name('dashboard.asesor');
        // ->middleware('role:asesor');
});


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
