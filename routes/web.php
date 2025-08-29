<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\SkemaController;

// ============================
// Halaman Utama
// ============================
Route::get('/', function () {
    return view('welcome');
});

// ============================
// Login & Register
// ============================
// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Pilih Role Register
Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

// Register Asesi
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

// Register Asesor
Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

// ============================
// Form Perencanaan (Asesor)
// ============================
Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
Route::post('/formperencanaan', [PerencanaanController::class, 'simpan'])->name('formperencanaan');

// ============================
// Meninjau Asesmen
// ============================
// Halaman utama meninjau
Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
// Lanjutin meninjau_asesor
Route::get('/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.view');
Route::post('/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor');

// ============================
// Laporan
// ============================
// Halaman utama laporan
Route::get('/laporan', [SkemaController::class, 'laporan'])->name('laporan');
// Lanjutan laporan-asesor
Route::get('/laporan-asesor', [PerencanaanController::class, 'laporan'])->name('laporan_asesor.show');
Route::post('/laporan-asesor', [PerencanaanController::class, 'simpanLanjutLaporan'])->name('laporan_asesor');

// ============================
// MAPA 02
// ============================
// Halaman utama MAPA02
Route::get('/mapa02', [SkemaController::class, 'mapa02'])->name('mapa02');
// Lanjutan mapa02-asesor
Route::get('/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
Route::post('/mapa02-asesor', [PerencanaanController::class, 'simpanLanjutmapa02'])->name('mapa02_asesor');

// ============================
// Logout
// ============================
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');