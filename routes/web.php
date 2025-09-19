<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\DataPesertaUjiController;
use App\Http\Controllers\ProfileAsesorController;
use App\Http\Controllers\Pgia07Controller;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\TambahAsesorController;
use App\Http\Controllers\Fria05aAsesiController;
use App\Http\Controllers\Fria05cController;
use App\Http\Controllers\Fria05cAdminController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Fria05bAdminController;
use App\Http\Controllers\Fria05aAdminController;

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

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Data Peserta Uji
Route::get('/data-peserta-uji', [DataPesertaUjiController::class, 'index'])->name('datapesertauji');
Route::resource('peserta', PesertaController::class);

// Detail Peserta Uji
Route::get('/peserta-uji/{id}', [DataPesertaUjiController::class, 'show'])->name('peserta.show');

//Profile Asesor
Route::middleware('auth')->group(function () {
    Route::get('/profileasesor/index', [ProfileAsesorController::class, 'show'])->name('profile.show');
    Route::get('/profileasesor/edit', [ProfileAsesorController::class, 'edit'])->name('profileasesor.edit');
    Route::put('/profileasesor/update', [ProfileAsesorController::class, 'update'])->name('profile.update');
});

//Asesor
//Lembar Pertanyaan PG
Route::get('/pgia07', [Pgia07Controller::class, 'index']);

//Pertanyaan Tertulis PG
Route::get('/fria05a', function () {
    return view('fria05a'); // pakai nama view kamu
})->name('fria05a');

Route::post('/simpan-pertanyaan', [PertanyaanController::class, 'simpan'])->name('simpan.pertanyaan');

Route::get('/fria05a1', function () {
    return view('fria05a1'); // pakai nama view kamu
})->name('fria05a1');

Route::get('/fria05a2', function () {
    return view('fria05a2'); // pakai nama view kamu
})->name('fria05a2');

Route::get('/tambahasesor', [TambahAsesorController::class, 'index']);

//Asesi
Route::get('/fria05a-asesi', [Fria05aAsesiController::class, 'index'])->name('fria05aAsesi.index');
Route::post('/fria05a-asesi/store', [Fria05aAsesiController::class, 'store'])->name('fria05aAsesi.store');

Route::get('/fria05c', [Fria05cController::class, 'index'])->name('fria05c.index');

// FRIA05B
Route::get('/fria05bAdmin', [Fria05bAdminController::class, 'index'])->name('fria05bAdmin');
Route::post('/unduh/fria05b', [PdfController::class, 'unduhFria05b'])->name('unduh.fria05b');

// FRIA05C
Route::get('/fria05cAdmin', [Fria05cAdminController::class, 'index'])->name('fria05cAdmin');
Route::post('/unduh/fria05c', [PdfController::class, 'unduhFria05c'])->name('unduh.fria05c');

// FRIA05A Admin
Route::get('/fria05aAdmin', [Fria05aAdminController::class, 'index'])->name('fria05aAdmin');
Route::post('/unduh/fria05aAdmin', [PdfController::class, 'unduhFria05aAdmin'])->name('unduh.fria05a');
