<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Asesi\PermohonanController;
use App\Http\Controllers\Admin\Form1AdminController;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\BandingAsesmenController;
use App\Http\Controllers\FormPraAsesmenController;
use App\Http\Controllers\Asesi\AsesmenMandiriController as AsesiAsesmenMandiriController;
use App\Http\Controllers\Asesor\AsesmenMandiriController as AsesorAsesmenMandiriController;
use App\Http\Controllers\Asesor\PersetujuanAsesmenController;


// Tambahan controller Wajar Alasan
use App\Http\Controllers\Asesi\WajarAlasanController as AsesiWajarAlasanController;
use App\Http\Controllers\Asesor\WajarAlasanController as AsesorWajarAlasanController;

// ================== AUTH ==================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// pilih role register
// halaman register asesi (default)
// REGISTER (gabungan asesi & asesor)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');


// ================== BANDINGS ASESMEN ==================
Route::get('/banding-asesmen', [BandingAsesmenController::class, 'index'])->name('banding.index');
Route::post('/banding-asesmen', [BandingAsesmenController::class, 'store'])->name('banding.store');
Route::post('/simpan-asesor', [BandingAsesmenController::class, 'simpanAsesor'])->name('simpan.asesor');

// ================== REDIRECT DEFAULT ==================
Route::get('/', function () {
    return redirect()->route('login');
});

// ================== DASHBOARD ==================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Asesi
    Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');

    // ================== PERMOHONAN (FR.APL.01) ==================
    Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
        Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
        Route::post('/store', [PermohonanController::class, 'store'])->name('store');
        Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
        Route::post('/store-dokumen', [PermohonanController::class, 'storeDokumen'])->name('storeDokumen');

        // status menunggu (jika sudah diajukan)
        Route::get('/menunggu', function () {
            return view('asesi.permohonan.menunggu');
        })->name('menunggu');
    });

    // ambil data skema via ajax
    Route::get('/get-skema/{id}', [PermohonanController::class, 'getSkema'])->name('get.skema');

    // ================== ASESOR ==================
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('asesor.dashboard');

    // ================== FORM ASESMEN ==================
    Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
    Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');
    Route::get('/asesi/formasesmen', [FormAsesmenController::class, 'asesi'])->name('asesi.formasesmen');

    // skema khusus
    Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');
    Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');
    Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');
    Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');
    Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');
    Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

    // pertanyaan esai
    Route::get('/form-asesmen/pertanyaan-esai', [FormAsesmenController::class, 'pertanyaanEsai'])->name('pertanyaan.esai');
    Route::post('/form-asesmen/pertanyaan-esai/store', [FormAsesmenController::class, 'storeEsai'])->name('pertanyaan.esai.store');
    Route::post('/form-asesmen/pertanyaan-esai/delete', [FormAsesmenController::class, 'deleteEsai'])->name('pertanyaan.esai.delete');

    // ================== ADMIN (FR.APL.01 - Permohonan) ==================
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [Form1AdminController::class, 'index'])->name('index');
            Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
            Route::post('/{id_permohonan}/update', [Form1AdminController::class, 'update'])->name('update');
        });

        // Daftar asesor
        Route::get('/asesor', [\App\Http\Controllers\Admin\AsesorController::class, 'index'])
            ->name('asesor.index');

        // Detail asesor
        Route::get('/asesor/{id}', [\App\Http\Controllers\Admin\AsesorController::class, 'show'])
            ->name('asesor.show');

        // Simpan asesor (dari modal)
        Route::post('/asesor/store', [\App\Http\Controllers\Admin\AsesorController::class, 'store'])
            ->name('asesor.store');

        // ==============================
        // 📌 ROUTE PENUGASAN (Fix)
        // ==============================
        Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
        Route::get('/penugasan/{id}/edit', [PenugasanController::class, 'edit'])->name('penugasan.edit');
        Route::put('/penugasan/{id}', [PenugasanController::class, 'update'])->name('penugasan.update');
    });


    // ================== ASESMEN MANDIRI (FR.APL.02 - ASESI) ==================
    Route::prefix('asesi/asesmen-mandiri')->name('asesi.asesmen_mandiri.')->group(function () {
        Route::get('form1', [AsesiAsesmenMandiriController::class, 'form1'])->name('form1');
        Route::get('form2', [AsesiAsesmenMandiriController::class, 'form2'])->name('form2');
        Route::get('form3', [AsesiAsesmenMandiriController::class, 'form3'])->name('form3');
        Route::get('/waiting', function () {
            return view('asesi.asesmen_mandiri.waiting');
        })->name('waiting');
        Route::post('store', [AsesiAsesmenMandiriController::class, 'store'])->name('store');

        // Tambahan: route simpan tanda tangan
        Route::post('ttd', [AsesiAsesmenMandiriController::class, 'storeTTD'])->name('ttd.store');

        // 🔹 route show jawaban asesi (hanya untuk asesi sendiri)
        Route::get('/{id}', [AsesiAsesmenMandiriController::class, 'show'])->name('show');
    });

    // ASESMEN MANDIRI (ASESOR)
    Route::prefix('asesor/asesmen-mandiri')->name('asesor.asesmen_mandiri.')->group(function () {
        Route::get('/', [AsesorAsesmenMandiriController::class, 'index'])->name('index');
        Route::get('/{asesi}', [AsesorAsesmenMandiriController::class, 'show'])->name('show');
        Route::post('/{asesi}/verifikasi', [AsesorAsesmenMandiriController::class, 'verifikasiStore'])->name('verifikasi.store');
    });

// ================== PERSETUJUAN ASESMEN (FR.AK.01) ==================
Route::prefix('asesor/persetujuan-asesmen')->name('asesor.persetujuan_asesmen.')->group(function () {
    Route::get('/form1', [PersetujuanAsesmenController::class, 'form1'])->name('form1');
    Route::post('/store', [PersetujuanAsesmenController::class, 'store'])->name('store');
});
    // ================== PRA ASESMEN ==================
    Route::get('form-pra-assesmen', [FormPraAsesmenController::class, 'index'])
        ->name('form_pra_assesmen');
});

Route::post(
    '/admin/permohonan/{id_permohonan}/update',
    [Form1AdminController::class, 'update']
)->name('admin.permohonan.update');

// ================== LOGOUT ==================
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ================== VIEW STATIC (opsional) ==================
Route::get('/asesi', function () {
    return view('asesi.index');
})->name('index-asesi');

Route::get('/asesmen', function () {
    return view('asesi.asesmen');
})->name('asesmen');

Route::get('/asesmen2', function () {
    return view('asesi.asesmen2');
})->name('asesmen2');

Route::get('/asesmen3', function () {
    return view('asesi.asesmen3');
})->name('asesmen3');

Route::get('/index', function () {
    return view('asesor.index');
})->name('index');

Route::get('/verifasesmen', function () {
    return view('asesor.verifasesmen');
})->name('verifasesmen');

Route::get('/verifasesmen2', function () {
    return view('asesor.verifasesmen2');
})->name('verifasesmen2');
