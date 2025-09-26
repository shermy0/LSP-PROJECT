<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\FormPerencanaan\MapaController;
use App\Http\Controllers\ModifikasiController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Asesi\PermohonanController;
use App\Http\Controllers\Admin\Form1AdminController;
use App\Models\UnitKompetensi;
use App\Http\Controllers\UmpanBalikController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Login & Register
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

// Register Asesi
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

// Register Asesor
Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard per role
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');
    Route::get('/dashboard/asesor', [DashboardController::class, 'asesor'])->name('dashboard.asesor');
});

/*
|--------------------------------------------------------------------------
| Form Perencanaan
|--------------------------------------------------------------------------
*/
Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
Route::post('/formperencanaan', [PerencanaanController::class, 'simpan'])->name('formperencanaan.simpan');

// MAPA 01
Route::prefix('form-perencanaan')->group(function () {
    Route::get('/mapa01', [MapaController::class, 'create'])->name('form.mapa01');

    Route::get('/mapa01/kode-unit/{skema_id}', [MapaController::class, 'kodeUnit'])->name('form.mapa01.kodeunit');
    Route::get('/mapa01/tambah-unit/{skema_id}', [MapaController::class, 'tambahUnit'])->name('form.mapa01.tambahunit');

    Route::post('/mapa01/{skema_id}/simpan-unit', [MapaController::class, 'simpanUnit'])->name('form.mapa01.simpanunit');
    Route::delete('/mapa01/{skema_id}/hapus-unit/{id}', [MapaController::class, 'hapusUnit'])->name('form.mapa01.hapusunit');

    Route::get('/get-skema/{id}', [MapaController::class, 'getSkema']);
    Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');
    Route::get('/mapa01/konfirmasi/{skema_id}', [MapaController::class, 'index'])->name('form.mapa01.konfirmasi');
});

Route::get('/get-unit/{id}', [MapaController::class, 'getUnit'])->name('form.mapa01.getunit');
Route::get('/search-unit', [MapaController::class, 'searchUnit'])->name('form.mapa01.searchunit');

// MAPA 02
Route::get('/mapa02', [SkemaController::class, 'mapa02'])->name('mapa02');
Route::get('/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
Route::post('/mapa02-asesor', [PerencanaanController::class, 'simpanLanjutmapa02'])->name('mapa02_asesor');

/*
|--------------------------------------------------------------------------
| Meninjau Asesmen
|--------------------------------------------------------------------------
*/
Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
Route::get('/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.view');
Route::post('/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor');

/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/
Route::get('/laporan', [SkemaController::class, 'laporan'])->name('laporan');
Route::get('/laporan-asesor', [PerencanaanController::class, 'laporan'])->name('laporan_asesor.show');
Route::post('/laporan-asesor', [PerencanaanController::class, 'simpanLanjutLaporan'])->name('laporan_asesor');

/*
|--------------------------------------------------------------------------
| FR.AK.03
|--------------------------------------------------------------------------
*/
Route::get('/frak3', [SkemaController::class, 'frak3'])->name('frak3');
Route::post('/umpan-balik', [UmpanBalikController::class, 'store'])->name('umpan-balik.store');

// validator (sementara static view)
Route::get('/fr-ak-03', function () {
    return view('fr.fr_ak_03');
});

//route asesor biar bisa otomatis
Route::get('/get-asesor/{skema_id}', [SkemaController::class, 'getAsesor']);

/*
|--------------------------------------------------------------------------
| Form Asesmen (untuk Asesor)
|--------------------------------------------------------------------------
*/
Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');
Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');
Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');
Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');
Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');
Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');
Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

/*
|--------------------------------------------------------------------------
| Form Permohonan (untuk Asesi)
|--------------------------------------------------------------------------
*/
Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
    Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
    Route::post('/store', [PermohonanController::class, 'store'])->name('store');
    Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
});

// API get skema & unit kompetensi (AJAX)
Route::get('/get-skema/{id}', [PermohonanController::class, 'getSkema'])->name('get.skema');

/*
|--------------------------------------------------------------------------
| Admin (FR.APL.01 - Form1)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::prefix('form1')->name('form1.')->group(function () {
        Route::get('/', [Form1AdminController::class, 'index'])->name('index');
        Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
