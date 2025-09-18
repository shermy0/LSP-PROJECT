<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\InstrumenController;

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
Route::post('/formperencanaan', [PerencanaanController::class, 'simpan'])->name('formperencanaan.simpan');

// ============================
// Meninjau Asesmen
// ============================
Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
Route::get('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.show');
Route::post('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor.store');

// ============================
// Laporan
// ============================

// Halaman utama laporan (FR.AK.05)
Route::get('/laporan', [SkemaController::class, 'laporan'])->name('laporan');

// Halaman daftar laporan
Route::get('/laporan_asesor', [PerencanaanController::class, 'laporan_asesor'])->name('laporan_asesor');

// Halaman Catatan Asesor & TTD (laporan_asesor)
Route::get('/laporan_asesor', [PerencanaanController::class, 'laporanAsesor'])
    ->name('laporan_asesor');

// Simpan data laporan
Route::post('/laporan_asesor', [PerencanaanController::class, 'store'])->name('laporan_asesor.store');

// Ajax ambil asesor & asesi
Route::get('/get-asesor/{skemaId}', [SkemaController::class, 'getAsesor']);
Route::get('/get-asesi/{skemaId}/{asesorId}', [SkemaController::class, 'getAsesi']);

// ============================
// MAPA 02
// ============================
Route::get('/mapa02', [SkemaController::class, 'showForm'])->name('mapa02');
Route::get('/mapa02/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
Route::post('/mapa02/mapa02-asesor', [PerencanaanController::class, 'simpanLanjutmapa02'])->name('mapa02_asesor.store');

Route::get('/mapa02/skema/{skemaId}/instrumen', [SkemaController::class, 'getInstrumenBySkema']);
Route::get('/mapa02/skema/{skemaId}/asesor', [SkemaController::class, 'getAsesor']);
Route::get('/mapa02/skema/{skemaId}/units', [SkemaController::class, 'getUnits']);

Route::post('/instrumen/simpan-potensi', [InstrumenController::class, 'simpanPotensi'])->name('instrumen.simpanPotensi');

// ============================
// FR VA
// ============================
Route::get('/fr-va/{periode}', [PerencanaanController::class, 'frVa'])->name('fr_va');
Route::get('/fr-va-asesor', [PerencanaanController::class, 'frVaAsesor'])->name('fr_va_asesor');
Route::post('/fr-va-asesor/simpan', [PerencanaanController::class, 'simpanLanjutfrVa'])->name('fr_va_asesor.simpan');

// ============================
// Logout
// ============================
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
