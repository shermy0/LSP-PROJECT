<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\FormPerencanaan\MapaController;
use App\Http\Controllers\SkemaController;
use App\Models\UnitKompetensi;
use App\Http\Controllers\ModifikasiController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Pgia07Controller;
use App\Http\Controllers\Fria05aController;
use App\Http\Controllers\Fria05a1Controller;
use App\Http\Controllers\Fria05a2Controller;
use App\Http\Controllers\Fria05aAsesiController;
use App\Http\Controllers\Fria05cController;
use App\Http\Controllers\Fria05aAdminController;
use App\Http\Controllers\Fria05bAdminController;
use App\Http\Controllers\Fria05cAdminController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DataPesertaUjiController;
use App\Http\Controllers\ProfileAsesorController;

Route::get('/pembuatan/{id_pembuatan}', [FormAsesmenController::class, 'showPembuatan'])
    ->name('pembuatan.show');

Route::get('/formasesmen/{id_skema}/esai', [FormAsesmenController::class, 'pertanyaanEsai'])->name('pertanyaan.esai');
Route::get('/formasesmen/pertanyaan-esai/create', [FormAsesmenController::class, 'createPertanyaanEsai'])->name('pertanyaan.esai.create');


Route::get('/form-asesmen/{id_skema}', [FormAsesmenController::class, 'showSkema'])
    ->name('formasesmen.show');

// Edit & Update
Route::get('/pertanyaan/esai/{id}/edit', [PertanyaanController::class, 'editEsai'])->name('pertanyaan.esai.edit');
Route::put('/pertanyaan/esai/{id}', [PertanyaanController::class, 'updateEsai'])->name('pertanyaan.esai.update');

// Hapus
Route::delete('/pertanyaan/esai/{id}', [PertanyaanController::class, 'destroyEsai'])->name('pertanyaan.esai.destroy');

// CRUD Lisan
Route::prefix('pertanyaan/lisan')->name('lisan.')->group(function () {
    Route::get('/create', [PertanyaanController::class, 'createLisan'])->name('create');
    Route::post('/store', [PertanyaanController::class, 'storeLisan'])->name('store');
    Route::get('/{id_skema}/crud', [PertanyaanController::class, 'crudLisan'])->name('crud');
    Route::get('/{id}/edit', [PertanyaanController::class, 'editLisan'])->name('edit');
    Route::put('/{id}', [PertanyaanController::class, 'updateLisan'])->name('update');
    Route::delete('/{id}', [PertanyaanController::class, 'destroyLisan'])->name('destroy');
});
Route::get('/form-asesmen/lisan/create', [PertanyaanController::class, 'createLisan'])
    ->name('pertanyaan.lisan.create');
Route::get('/kelompok-lisan/{id_skema}', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->defaults('jenis', 'lisan');
Route::put('/pertanyaan/lisan/{id}', [PertanyaanController::class, 'updateLisan'])
    ->name('pertanyaan.lisan.update');
    // Kelompok Pekerjaan Lisan
Route::get('/lisan/kelompok/{id_skema}', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->name('pertanyaan.lisan.kelompok');
// Route untuk pertanyaan Lisan per skema
Route::get('/form-asesmen/pertanyaan-lisan/{id_skema}', [FormAsesmenController::class, 'pertanyaanLisan'])
    ->name('formasesmen.pertanyaanLisan');
Route::get('/lisan/{id_skema}/crud', [PertanyaanController::class, 'crudLisan'])
    ->name('lisan.crud');

    
// Form input esai via query string (jumlah & id_skema)
Route::get('/pertanyaan/esai/create', [PertanyaanController::class, 'createEsai'])
    ->name('pertanyaan.esai.create'); // <-- gunakan ini di Blade

// Form Asesmen → pilih skema → input esai (dynamic berdasarkan id_skema)
Route::get('/form-asesmen/pertanyaan-esai/{id_skema}', [FormAsesmenController::class, 'pertanyaanEsai'])
    ->name('formasesmen.pertanyaanEsai');

// tanda tangan asesor untuk pembuatan soal
Route::get('/tanda_tangan_asesmen/{id_skema}/{id_pembuatan_pertanyaan}',  
    [PertanyaanController::class, 'formTTDAsesor']
)->name('tanda.tangan.asesmen');

Route::post('/tanda_tangan_asesmen/{id_skema}/{id_pembuatan_pertanyaan}/simpan',  
    [PertanyaanController::class, 'simpanTTDAsesor']
)->name('tanda.tangan.asesmen.simpan');


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
Route::get('/dashboard/asesor', [DashboardController::class, 'asesor'])
    ->name('asesor.dashboard');

Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');

Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');

Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');

Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');

Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');

Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

// Form Perencanaan untuk Asesor
Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');

/*
|--------------------------------------------------------------------------|
| ROUTE PERTANYAAN                                                         |
|--------------------------------------------------------------------------|
*/


Route::get('/esai/{id_skema}/{id_kelompok}', [PertanyaanController::class, 'crudEsai'])
    ->name('esai.crud');



// PertanyaanController → simpan esai
Route::post('/pertanyaan/esai/store', [PertanyaanController::class, 'storeEsai'])->name('pertanyaan.esai.store');

// Index semua pertanyaan
Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');

// Lisan
Route::get('/pertanyaan/lisan', [PertanyaanController::class, 'createLisan'])->name('pertanyaan.lisan.create');
Route::post('/pertanyaan/lisan', [PertanyaanController::class, 'storeLisan'])->name('pertanyaan.lisan.store');

// Pilihan Ganda
Route::get('/pertanyaan/pg', [PertanyaanController::class, 'createPG'])->name('pertanyaan.pg.create');
Route::post('/pertanyaan/pg', [PertanyaanController::class, 'storePG'])->name('pertanyaan.pg.store');

// CRUD Demonstrasi
Route::get('/demonstrasi/create', [DemonstrasiController::class, 'create'])->name('demonstrasi.create');
Route::post('/demonstrasi/store', [DemonstrasiController::class, 'store'])->name('demonstrasi.store');
Route::get('/demonstrasi/{id_skema}/crud', [DemonstrasiController::class, 'crud'])->name('demonstrasi.crud');
Route::get('/demonstrasi/{id}/edit', [DemonstrasiController::class, 'edit'])->name('demonstrasi.edit');
Route::put('/demonstrasi/{id}/update', [DemonstrasiController::class, 'update'])->name('demonstrasi.update');
Route::delete('/demonstrasi/{id}/delete', [DemonstrasiController::class, 'destroy'])->name('demonstrasi.destroy');
// Form Asesmen → per skema → masuk ke pertanyaan demonstrasi
// Form Asesmen → per skema → masuk ke pertanyaan demonstrasi
Route::get('/form-asesmen/pertanyaan-demonstrasi/{id_skema}', 
    [DemonstrasiController::class, 'index']
)->name('formasesmen.pertanyaanDemonstrasi');


// Kelompok pekerjaan demonstrasi
Route::get('/form-asesmen/{id_skema}/kelompok-demonstrasi', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->name('pertanyaan.demonstrasi.kelompok');



/*
|--------------------------------------------------------------------------|
| ROUTE JAWABAN                                                            |
|--------------------------------------------------------------------------|
*/

Route::prefix('jawaban')->group(function () {
    Route::get('/{id_skema}', [JawabanController::class, 'index'])->name('jawaban.index');
    Route::post('/store', [JawabanController::class, 'store'])->name('jawaban.store');
});


/*
|--------------------------------------------------------------------------|
| ROUTE FORM ASESMEN + PERENCANAAN                                         |
|--------------------------------------------------------------------------|
*/

// ⛔ INI JANGAN DIUBAH (Form Perencanaan tetap sama)
Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');

Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');
Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');
Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');
Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');
Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');
Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

// Form Asesmen (ambil semua skema dari DB)
Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');

/*
|--------------------------------------------------------------------------|
| ROUTE AUTH (LOGIN & REGISTER)                                             |
|--------------------------------------------------------------------------|
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Pilih role register
Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

// Register Asesi
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

// Register Asesor
Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

/*
|--------------------------------------------------------------------------|
| ROUTE DASHBOARD                                                           |
|--------------------------------------------------------------------------|
*/

// Admin
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

// Asesi
Route::middleware(['auth', 'role:asesi'])->group(function () {
    Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');
});

/*
|--------------------------------------------------------------------------|
| ROUTE LOGOUT                                                              |
|--------------------------------------------------------------------------|
*/
//dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');

    // Asesi
    // Asesi
Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');


    // Asesor
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('dashboard.asesor');
});

Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// tampilkan kelompok pekerjaan per skema
// web.php
Route::get('/form-asesmen/{id_skema}/kelompok', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->defaults('jenis', 'lisan')
    ->name('pertanyaan.lisan.kelompok');

// ========== ROUTE PILIHAN GANDA (FLOW ADMIN/ASESI/ASESOR) ==========

//asesor
Route::get('/pgia07', [Pgia07Controller::class, 'index'])->name('pgia07.index');
Route::get('/fria05a', [Fria05aController::class, 'index'])->name('fria05a.index');
Route::get('/fria05a1', [Fria05aController::class, 'step1'])->name('fria05a.step1');
Route::get('/fria05a2', [Fria05aController::class, 'step2'])->name('fria05a.step2');
Route::get('/tambahasesor', [Fria05aController::class, 'tambahAsesor'])->name('tambah.asesor');
Route::post('/fria05a/store', [Fria05aController::class, 'store'])->name('fria05a.store');

//asesi 
Route::get('/fria05aAsesi', [Fria05aAsesiController::class, 'index'])->name('fria05aAsesi.index');
Route::post('/fria05aAsesi/store', [Fria05aAsesiController::class, 'store'])->name('fria05aAsesi.store');
Route::get('/fria05c', [Fria05cController::class, 'index'])->name('fria05c.index');

//admin
Route::get('fria05aAdmin', [Fria05aAdminController::class, 'index'])->name('fria05aAdmin');
Route::get('fria05bAdmin', [Fria05bAdminController::class, 'index'])->name('fria05bAdmin');
Route::get('fria05cAdmin', [Fria05cAdminController::class, 'index'])->name('fria05cAdmin');

Route::post('fria05cAdmin/unduh', [PdfController::class, 'unduhFria05c'])->name('unduh.fria05c');
Route::post('fria05bAdmin/unduh', [PdfController::class, 'unduhFria05b'])->name('unduh.fria05b');
Route::post('fria05aAdmin/unduh', [PdfController::class, 'unduhFria05a'])->name('unduh.fria05a');

// ================== DATA PESERTA UJI ==================
Route::get('datapesertauji', [DataPesertaUjiController::class, 'index'])->name('datapesertauji');
Route::resource('peserta', DataPesertaUjiController::class);

// ================== PROFILE ASESOR ==================
Route::prefix('profileasesor')->group(function () {
    Route::get('/', [ProfileAsesorController::class, 'show'])->name('profile.show');
    Route::get('/edit', [ProfileAsesorController::class, 'edit'])->name('profileasesor.edit');
    Route::put('/update', [ProfileAsesorController::class, 'update'])->name('profile.update');
});
Route::get('/form-asesmen/{id_skema}/kelompok-essai', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->defaults('jenis', 'essai')
    ->name('pertanyaan.essai.kelompok');