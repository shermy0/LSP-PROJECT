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

// form perencanaan mapa 01
Route::prefix('form-perencanaan')->group(function () {
    Route::get('/mapa01', [MapaController::class, 'create'])->name('form.mapa01');

    Route::get('/mapa01/kode-unit/{skema_id}', [MapaController::class, 'kodeUnit'])->name('form.mapa01.kodeunit');

    // Unit per kelompok
Route::get('/mapa01/{skema_id}/kelompok/{kelompok_id}/tambah-unit', [MapaController::class, 'tambahUnit'])
    ->name('form.mapa01.tambahunit');
    Route::post('/mapa01/{skema_id}/kelompok/{kelompok_id}/simpan-unit', [MapaController::class, 'simpanUnit'])->name('form.mapa01.simpanunit');

    Route::delete('/mapa01/{skema_id}/hapus-unit/{id}', [MapaController::class, 'hapusUnit'])->name('form.mapa01.hapusunit');

    // Kelompok pekerjaan
    Route::post('/{skema_id}/tambah-kelompok', [MapaController::class, 'tambahKelompok'])->name('form.mapa01.tambahKelompok');
    Route::delete('/{skema_id}/hapus-kelompok/{kelompok_id}', [MapaController::class, 'hapusKelompok'])->name('form.mapa01.hapusKelompok');

    // Get skema
    Route::get('/get-skema/{id}', [MapaController::class, 'getSkema']);

    // Modifikasi & konfirmasi
    Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');
    Route::get('/mapa01/konfirmasi/{skema_id}', [MapaController::class, 'index'])->name('form.mapa01.konfirmasi');

    // Edit & update unit
    Route::get('/mapa01/edit-unit/{skema_id}/{id}', [MapaController::class, 'editUnit'])->name('form.mapa01.editunit');
    Route::put('/mapa01/update-unit/{skema_id}/{id}', [MapaController::class, 'updateUnit'])->name('form.mapa01.updateunit');
});




Route::get('/get-unit/{id}', [MapaController::class, 'getUnit'])->name('form.mapa01.getunit');
Route::get('/search-unit', [MapaController::class, 'searchUnit'])->name('form.mapa01.searchunit');


// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});

// Dashboard Asesi
Route::middleware(['auth', 'role:asesi'])->group(function () {
    Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');
});

Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');