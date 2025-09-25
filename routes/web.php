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
use App\Http\Controllers\BandingAsesmenController;

// Tambahan controller Asesmen Mandiri
use App\Http\Controllers\Asesi\AsesmenMandiriController as AsesiAsesmenMandiriController;
use App\Http\Controllers\Asesor\AsesmenMandiriController as AsesorAsesmenMandiriController;

// ================== AUTH ==================
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
    Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
        Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
        Route::post('/store', [PermohonanController::class, 'store'])->name('store');
        Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
        Route::post('/store-dokumen', [PermohonanController::class, 'storeDokumen'])->name('storeDokumen');
    });
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

    // ================== ADMIN (FR.APL.01 - Form1) ==================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [Form1AdminController::class, 'index'])->name('index');
            Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
        });
    });

    // ================== ASESMEN MANDIRI ==================
    Route::prefix('asesi/asesmen-mandiri')->name('asesi.asesmen_mandiri.')->group(function () {
        Route::get('/form1', [AsesiAsesmenMandiriController::class, 'form1'])->name('form1');
        Route::get('/form2', [AsesiAsesmenMandiriController::class, 'form2'])->name('form2');
        Route::get('/form3', [AsesiAsesmenMandiriController::class, 'form3'])->name('form3');
        Route::get('/form4', [AsesiAsesmenMandiriController::class, 'form4'])->name('form4');
    });

    Route::prefix('asesor/asesmen-mandiri')->name('asesor.asesmen_mandiri.')->group(function () {
        Route::get('/form1', [AsesorAsesmenMandiriController::class, 'form1'])->name('form1');
        Route::get('/form2', [AsesorAsesmenMandiriController::class, 'form2'])->name('form2');
        Route::get('/form3', [AsesorAsesmenMandiriController::class, 'form3'])->name('form3');
    });
});

Route::post('/admin/permohonan/{id_permohonan}/update', 
    [Form1AdminController::class, 'update'])->name('admin.permohonan.update');

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
