<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\PenyusunController;

// Tampilkan form laporan_asesor tertentu
Route::get('/laporan_asesor/{id}/create', [PenyusunController::class, 'create'])->name('laporan_asesor.create');

// Simpan laporan
Route::post('/laporan_asesor/store', [PenyusunController::class, 'store'])->name('laporan.store');

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
// Lanjutkan meninjau_asesor
Route::get('ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.view');
Route::post('ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor');
Route::post('/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor');

// ============================
// Laporan
// ============================
// Halaman daftar laporan asesmen
Route::get('/laporan-asesor', [PerencanaanController::class, 'laporan'])
    ->name('laporan_asesor.index');
// Simpan catatan asesmen
Route::post('/laporan-asesor', [PerencanaanController::class, 'simpanLanjutLaporan'])
    ->name('laporan_asesor.store');
// Halaman laporan umum (kalau memang perlu dari SkemaController)
Route::get('/laporan', [SkemaController::class, 'laporan'])
    ->name('laporan');
// Ambil data asesor & asesi (AJAX)
Route::get('/get-asesor/{skemaId}', [SkemaController::class, 'getAsesor']);
Route::get('/get-asesi/{skemaId}/{asesorId}', [SkemaController::class, 'getAsesi']);
Route::get('/get-unit/{skemaId}', [SkemaController::class, 'getUnits']);

// ============================
// MAPA 02
// ============================
Route::get('/mapa02', [SkemaController::class, 'showForm'])->name('mapa02');
Route::get('mapa02/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
Route::post('mapa02/mapa02-asesor', [PerencanaanController::class, 'simpanmapa02'])->name('mapa02_asesor');
Route::get('/mapa02/skema/{skemaId}/instrumen', [SkemaController::class, 'getInstrumenBySkema']);
// AMBIL ASESOR
Route::get('/mapa02/skema/{skemaId}/asesor', [SkemaController::class, 'getAsesor']);
Route::post('/instrumen/simpan-potensi', [InstrumenController::class, 'simpanPotensi'])->name('instrumen.simpanPotensi');
Route::get('/mapa02/skema/{skemaId}/units', [SkemaController::class, 'getUnits']);

// ============================
// FR VA
// ============================
// FR VA (halaman awal dengan periode)
Route::get('/fr-va/{periode}', [PerencanaanController::class, 'frVa'])->name('fr_va');
// FR VA Asesor (halaman lanjutan)
Route::get('/fr-va-asesor', [PerencanaanController::class, 'frVaAsesor'])->name('fr_va_asesor');
// Simpan dari FR VA ke FR VA Asesor
Route::post('/fr-va-asesor/simpan', [PerencanaanController::class, 'simpanLanjutfrVa'])->name('fr_va_asesor.simpan');
// FR VA (halaman awal dengan periode)
Route::get('/fr-va/{periode}', [PerencanaanController::class, 'frVa'])->name('fr_va');

// FR VA Asesor (halaman lanjutan)
Route::get('/fr-va-asesor', [PerencanaanController::class, 'frVaAsesor'])->name('fr_va_asesor');

// Simpan dari FR VA ke FR VA Asesor
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
