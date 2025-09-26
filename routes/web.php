<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\FormPerencanaan\MapaController;
use App\Http\Controllers\SkemaController;
use App\Models\UnitKompetensi;
use App\Http\Controllers\ModifikasiController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\FormPerencanaanController;



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
// Halaman daftar skema
Route::get('/perencanaan/skema', [FormPerencanaanController::class, 'index'])
    ->name('formperencanaan.index');

// Halaman form perencanaan sesuai skema
Route::get('/perencanaan/skema/{id_skema}', [FormPerencanaanController::class, 'show'])
    ->name('formperencanaan.show');

Route::post('/formperencanaan', [PerencanaanController::class, 'simpan'])->name('formperencanaan.simpan');
Route::post('/mapa01/{skema}/pendekatan', [MapaController::class, 'simpanPendekatan'])
    ->name('form.mapa01.simpanPendekatan');

// form perencanaan mapa 01
Route::prefix('form-perencanaan')->group(function () {
    // MAPA01
    Route::post('/mapa01/{skema_id}/simpan-semua', [MapaController::class, 'simpanSemua'])->name('form.mapa01.simpanSemua');
// routes/web.php
Route::get('/mapa01/get-tujuan/{skemaId}', [MapaController::class, 'getTujuan'])->name('mapa01.getTujuan');

Route::post('/mapa01/{skema_id}/pendekatan', [MapaController::class, 'simpanPendekatan'])
    ->name('form.mapa01.simpanPendekatan');

Route::post('/mapa01/{skema_id}/konteks', [MapaController::class, 'simpanKonteksAsesmen'])
    ->name('form.mapa01.simpanKonteks');

Route::post('/mapa01/{skema_id}/dasar-asesmen', [MapaController::class, 'simpanDasarAsesmen'])
    ->name('form.mapa01.simpanDasarAsesmen');


    Route::get('/mapa01', [MapaController::class, 'create'])->name('form.mapa01');

    // Tujuan Asesmen
    Route::post('/mapa01/simpan-tujuan', [MapaController::class, 'simpanTujuan'])
        ->name('mapa01.simpanTujuan');
            // Unit per skema & kelompok
    Route::get('/mapa01/kode-unit/{skema_id}', [MapaController::class, 'kodeUnit'])->name('form.mapa01.kodeunit');
    Route::get('/mapa01/{skema_id}/kelompok/{kelompok_id}/tambah-unit', [MapaController::class, 'tambahUnit'])->name('form.mapa01.tambahunit');
    Route::post('/mapa01/{skema_id}/kelompok/{kelompok_id}/simpan-unit', [MapaController::class, 'simpanUnit'])->name('form.mapa01.simpanunit');
    Route::delete('/mapa01/{skema_id}/hapus-unit/{id}', [MapaController::class, 'hapusUnit'])->name('form.mapa01.hapusunit');

    // Kelompok pekerjaan
    Route::post('/mapa01/{skema_id}/tambah-kelompok', [MapaController::class, 'tambahKelompok'])->name('form.mapa01.tambahKelompok');
    Route::delete('/mapa01/{skema_id}/hapus-kelompok/{kelompok_id}', [MapaController::class, 'hapusKelompok'])->name('form.mapa01.hapusKelompok');

    // Get skema
    Route::get('/mapa01/get-skema/{id}', [MapaController::class, 'getSkema'])->name('form.mapa01.getskema');

    // Modifikasi & konfirmasi
    Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');
// Konfirmasi
Route::get('/mapa01/konfirmasi/{skema_id}', [MapaController::class, 'konfirmasi'])
    ->name('form.mapa01.konfirmasi');

Route::post('/mapa01/konfirmasi/{skema_id}/simpan', [MapaController::class, 'simpanKonfirmasi'])
    ->name('form.mapa01.konfirmasi.simpan');

    // Edit & update unit
    Route::get('/mapa01/edit-unit/{skema_id}/{id}', [MapaController::class, 'editUnit'])->name('form.mapa01.editunit');
    Route::put('/mapa01/update-unit/{skema_id}/{id}', [MapaController::class, 'updateUnit'])->name('form.mapa01.updateunit');
    // ============================
// MAPA 01 & MAPA 02
// ============================
Route::get('/mapa02', [PerencanaanController::class, 'mapa02'])->name('form.mapa02');


});
// ============================
// MAPA 02
// ============================
Route::get('/mapa02', [SkemaController::class, 'showForm'])->name('mapa02.show');
Route::get('/mapa02/skema/{skemaId}/kelompok', [MapaController::class, 'getKelompokBySkema']);
Route::get('mapa02/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
Route::post('mapa02/mapa02-asesor', [PerencanaanController::class, 'simpanLanjutmapa02'])->name('mapa02_asesor');
Route::get('/mapa02/skema/{skemaId}/instrumen', [SkemaController::class, 'getInstrumenBySkema']);
// AMBIL ASESOR
Route::get('/mapa02/skema/{skemaId}/asesor', [SkemaController::class, 'getAsesor']);
Route::post('/instrumen/simpan-potensi', [InstrumenController::class, 'simpanPotensi'])->name('instrumen.simpanPotensi');
Route::get('/mapa02/skema/{skemaId}/units', [SkemaController::class, 'getUnits']);
Route::get('/asesor/search', [AsesorController::class, 'search'])->name('asesor.search');


Route::get('/get-unit/{skema_id}', [MapaController::class, 'getUnitsBySkema']);


Route::get('/get-unit/{id}', [MapaController::class, 'getUnit'])->name('form.mapa01.getunit');
Route::get('/search-unit', [MapaController::class, 'searchUnit'])->name('form.mapa01.searchunit');


// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});
// ============================
// Meninjau Asesmen
// ============================
Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
Route::get('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.show');
Route::post('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor.store');

// ============================
// Laporan
// ============================

Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');


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
