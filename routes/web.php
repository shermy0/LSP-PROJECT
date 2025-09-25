<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\SkemaController;

Route::get('/', function () {
    return view('welcome');
});

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

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});

// Dashboard Asesi
Route::middleware(['auth', 'role:asesi'])->group(function () {
    Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');
});

// Meninjau Asesmen
Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
Route::get('/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.view');
Route::post('/meninjau-asesmen/store', [SkemaController::class, 'store'])->name('meninjau_asesmen.store');

// simpan dan lanjut
Route::post('/formperencanaan', [PerencanaanController::class, 'simpan'])->name('formperencanaan');
Route::post('/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor');
Route::get('/ninjau-asesmen-asesor/{asesor_id}', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.view');

Route::get('/get-asesor/{skema_id}', [SkemaController::class, 'getAsesor']);
// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');