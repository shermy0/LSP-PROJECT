<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Asesi\PermohonanController;
use App\Http\Controllers\Admin\Form1AdminController;
use App\Http\Controllers\Admin\PenugasanController;
use App\Http\Controllers\FormPraAsesmenController;
use App\Http\Controllers\Asesi\AsesmenMandiriController as AsesiAsesmenMandiriController;
use App\Http\Controllers\Asesor\AsesmenMandiriController as AsesorAsesmenMandiriController;
use App\Http\Controllers\Asesor\PersetujuanAsesmenController as AsesorPersetujuanController;
use App\Http\Controllers\Asesi\PersetujuanAsesmenController as AsesiPersetujuanController;
use App\Http\Controllers\Asesor\PenyesuaianWajarController as AsesorPenyesuaianWajarController;
use App\Http\Controllers\Asesi\PenyesuaianWajarController as AsesiPenyesuaianWajarController;

// ================== AUTH (tanpa middleware auth) ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// ================== REDIRECT DEFAULT ==================
// ================== REDIRECT DEFAULT ==================
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin': return redirect()->route('admin.dashboard');
            case 'asesor': return redirect()->route('asesor.dashboard');
            case 'asesi': return redirect()->route('asesi.dashboard');
            default: return redirect()->route('login');
        }
    }
    return redirect()->route('login');
});

// ================== LOGOUT (dengan middleware auth) ==================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== ROUTES WITH AUTH ==================
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('asesor.dashboard');

    // ================== PERMOHONAN (FR.APL.01) ==================
    Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
        Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
        Route::post('/store', [PermohonanController::class, 'store'])->name('store');
        Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
        Route::post('/store-dokumen', [PermohonanController::class, 'storeDokumen'])->name('storeDokumen');
        Route::get('/menunggu', function () {
            return view('asesi.permohonan.menunggu');
        })->name('menunggu');
    });

    // ambil data skema via ajax
    Route::get('/get-skema/{id}', [PermohonanController::class, 'getSkema'])->name('get.skema');

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

    // ================== ADMIN ==================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Permohonan
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [Form1AdminController::class, 'index'])->name('index');
            Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
            Route::post('/{id_permohonan}/update', [Form1AdminController::class, 'update'])->name('update');
        });

        // Asesor
        Route::get('/asesor', [\App\Http\Controllers\Admin\AsesorController::class, 'index'])->name('asesor.index');
        Route::get('/asesor/{id}', [\App\Http\Controllers\Admin\AsesorController::class, 'show'])->name('asesor.show');
        Route::post('/asesor/store', [\App\Http\Controllers\Admin\AsesorController::class, 'store'])->name('asesor.store');

        // Penugasan
        Route::get('/penugasan', [PenugasanController::class, 'index'])->name('penugasan.index');
        Route::get('/penugasan/{id}/edit', [PenugasanController::class, 'edit'])->name('penugasan.edit');
        Route::put('/penugasan/{id}', [PenugasanController::class, 'update'])->name('penugasan.update');

        // Banding Asesmen untuk Admin
        Route::resource('banding-asesmen', \App\Http\Controllers\Admin\BandingAsesmenController::class)
            ->only(['index', 'show']);
        Route::get('/banding-asesmen/{id}/download', [\App\Http\Controllers\Admin\BandingAsesmenController::class, 'downloadPdf'])->name('banding-asesmen.download');
    });

    // ================== ASESMEN MANDIRI (FR.APL.02) ==================
    // Asesi
    Route::prefix('asesi/asesmen-mandiri')->name('asesi.asesmen_mandiri.')->group(function () {
        Route::get('form1', [AsesiAsesmenMandiriController::class, 'form1'])->name('form1');
        Route::get('form2', [AsesiAsesmenMandiriController::class, 'form2'])->name('form2');
        Route::get('form3', [AsesiAsesmenMandiriController::class, 'form3'])->name('form3');
        Route::get('/waiting', function () {
            return view('asesi.asesmen_mandiri.waiting');
        })->name('waiting');
        Route::post('store', [AsesiAsesmenMandiriController::class, 'store'])->name('store');
        Route::post('ttd', [AsesiAsesmenMandiriController::class, 'storeTTD'])->name('ttd.store');
        Route::get('/{id}', [AsesiAsesmenMandiriController::class, 'show'])->name('show');
    });

    // Asesor
    Route::prefix('asesor/asesmen-mandiri')->name('asesor.asesmen_mandiri.')->group(function () {
        Route::get('/', [AsesorAsesmenMandiriController::class, 'index'])->name('index');
        Route::get('/{asesi}', [AsesorAsesmenMandiriController::class, 'show'])->name('show');
        Route::post('/{asesi}/verifikasi', [AsesorAsesmenMandiriController::class, 'verifikasiStore'])->name('verifikasi.store');
    });

    // ================== PERSETUJUAN ASESMEN (FR.AK.01) ==================
    // Asesor
    Route::prefix('asesor/persetujuan-asesmen')->name('asesor.persetujuan_asesmen.')->group(function () {
        Route::get('/', [AsesorPersetujuanController::class, 'index'])->name('index');
        Route::get('/create/{id_permohonan}', [AsesorPersetujuanController::class, 'create'])->name('create');
        Route::post('/', [AsesorPersetujuanController::class, 'store'])->name('store');
        Route::get('/{id}', [AsesorPersetujuanController::class, 'show'])->name('show');
        Route::put('/{id}', [AsesorPersetujuanController::class, 'update'])->name('update');
        Route::post('/{id}/signature', [AsesorPersetujuanController::class, 'storeSignature'])->name('signature');
    });

    // Asesi
    Route::prefix('asesi/persetujuan-asesmen')->name('asesi.persetujuan_asesmen.')->group(function () {
        Route::get('/', [AsesiPersetujuanController::class, 'index'])->name('index');
        Route::get('/{id}', [AsesiPersetujuanController::class, 'show'])->name('show');
        Route::post('/{id}/signature', [AsesorPersetujuanController::class, 'storeSignature'])->name('signature');
    });

    // ================== PENYESUAIAN WAJAR (FR.AK.07) ==================
    // Asesor
    Route::prefix('asesor/penyesuaian-wajar')->name('asesor.penyesuaian_wajar.')->group(function () {
        Route::get('/', [AsesorPenyesuaianWajarController::class, 'index'])->name('index');
        Route::get('/create/{id_permohonan}', [AsesorPenyesuaianWajarController::class, 'create'])->name('create');
        Route::post('/', [AsesorPenyesuaianWajarController::class, 'store'])->name('store');
        Route::get('/{id}', [AsesorPenyesuaianWajarController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AsesorPenyesuaianWajarController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AsesorPenyesuaianWajarController::class, 'update'])->name('update');
        Route::post('/{id}/signature', [AsesorPenyesuaianWajarController::class, 'storeSignature'])->name('signature');
    });

    // Asesi
    Route::prefix('asesi/penyesuaian-wajar')->name('asesi.penyesuaian_wajar.')->group(function () {
        Route::get('/', [AsesiPenyesuaianWajarController::class, 'index'])->name('index');
        Route::get('/{id}', [AsesiPenyesuaianWajarController::class, 'show'])->name('show');
        Route::post('/{id}/signature', [AsesiPenyesuaianWajarController::class, 'storeSignature'])->name('signature');
    });

    // ================== BANDING ASESMEN (FR.AK.04) UNTUK ASESI ==================
    Route::prefix('asesi/banding-asesmen')->name('asesi.banding_asesmen.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Asesi\BandingAsesmenController::class, 'index'])->name('index');
        Route::get('/create/{id_permohonan}', [\App\Http\Controllers\Asesi\BandingAsesmenController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Asesi\BandingAsesmenController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Asesi\BandingAsesmenController::class, 'show'])->name('show');
        Route::post('/{id}/signature', [\App\Http\Controllers\Asesi\BandingAsesmenController::class, 'storeSignature'])->name('signature');
    });

    // ================== PRA ASESMEN ==================
    Route::get('form-pra-assesmen', [FormPraAsesmenController::class, 'index'])->name('form_pra_assesmen');
});

// Route untuk update permohonan admin (tambahan)
Route::post('/admin/permohonan/{id_permohonan}/update', [Form1AdminController::class, 'update'])->name('admin.permohonan.update');