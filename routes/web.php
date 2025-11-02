<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\FormPerencanaan\MapaController;
use App\Http\Controllers\SkemaController;
use App\Models\UnitKompetensi;
use App\Http\Controllers\RekamanAsesmenController;
use App\Http\Controllers\ModifikasiController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Asesi\PermohonanController;
use App\Http\Controllers\Admin\Form1AdminController;
use App\Http\Controllers\OpsiJawabanController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DataPesertaUjiController;
use App\Http\Controllers\ProfileAsesorController;
use App\Http\Controllers\DemonstrasiController;
use App\Http\Controllers\JawabanDemonstrasiController;




use App\Http\Controllers\CeklisObservasiController;

Route::prefix('ceklisobservasi')->group(function () {
    Route::get('/',        [CeklisObservasiController::class, 'index'])->name('ceklisobservasi.index');
    Route::get('/data/{skemaId}', [CeklisObservasiController::class, 'loadData'])->name('ceklisobservasi.data');
    Route::post('/store',  [CeklisObservasiController::class, 'store'])->name('ceklisobservasi.store');
});



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



// tambah ini
Route::get('/rekap-asesmen/{id_skema?}', [RekamanAsesmenController::class, 'index'])
    ->name('rekap.asesmen');
Route::get('/rekaman/create/{id_skema}', [RekamanAsesmenController::class, 'create'])
    ->name('rekaman.create');

Route::get('/rekaman/create/{id_skema}', [RekamanAsesmenController::class, 'create'])->name('rekaman.create');
Route::post('/rekaman/store', [RekamanAsesmenController::class, 'store'])->name('rekaman.store');
Route::get('/rekaman/show/{id}', [RekamanAsesmenController::class, 'show'])->name('rekaman.show');



// CRUD Lisan
Route::prefix('pertanyaan/lisan')->name('lisan.')->group(function () {
    Route::get('/create', [PertanyaanController::class, 'createLisan'])->name('create');
    Route::post('/store', [PertanyaanController::class, 'storeLisan'])->name('store');
    Route::get('/{id_skema}/{id_kelompok}/crud', [PertanyaanController::class, 'crudLisan'])->name('crud');
    Route::get('/{id}/edit', [PertanyaanController::class, 'editLisan'])->name('edit');
    Route::put('/{id}', [PertanyaanController::class, 'updateLisan'])->name('update');
    Route::delete('/{id}', [PertanyaanController::class, 'destroyLisan'])->name('destroy');
});
Route::get('/skema/{id}/kelompok-lisan', [PertanyaanController::class, 'kelompokLisan'])->name('kelompok.pekerjaan.lisan');
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
Route::get('/kelompok-lisan/{id_skema}/{jenis?}', [PertanyaanController::class, 'kelompokPekerjaan'])->name('kelompok.pekerjaan');
    
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
Route::get('/juniortechnicalsupport_asesi', [FormAsesmenController::class, 'juniortechnicalsupport_asesi'])->name('formasesmen.juniortechnicalsupport_asesi');

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



// CRUD Demonstrasi
Route::get('/demonstrasi/create', [DemonstrasiController::class, 'create'])->name('demonstrasi.create');
Route::post('/demonstrasi/store', [DemonstrasiController::class, 'store'])->name('demonstrasi.store');
Route::get('/demonstrasi/{id_skema}/crud', [DemonstrasiController::class, 'crud'])->name('demonstrasi.crud');
Route::get('/demonstrasi/{id}/edit', [DemonstrasiController::class, 'edit'])->name('demonstrasi.edit');
Route::put('/demonstrasi/{id}/update', [DemonstrasiController::class, 'update'])->name('demonstrasi.update');
Route::delete('/demonstrasi/{id}/delete', [DemonstrasiController::class, 'destroy'])->name('demonstrasi.destroy');

Route::prefix('demonstrasi')->group(function () {
   Route::get('/create-tugas', [DemonstrasiController::class, 'createTugas'])->name('demonstrasi.createTugas');

   Route::post('/store-tugas', [DemonstrasiController::class, 'storeTugas'])->name('demonstrasi.storeTugas');

   Route::post('/store', [DemonstrasiController::class, 'store'])->name('demonstrasi.store');
   Route::get('/kelompok/{id_skema}', [DemonstrasiController::class, 'kelompok'])->name('pertanyaan.demonstrasi.kelompok');

   // CRUD tugas
   Route::get('/crud/{id_skema}/{id_kelompok}', [DemonstrasiController::class, 'crud'])->name('demonstrasi.crud');
   Route::get('/edit/{id}', [DemonstrasiController::class, 'edit'])->name('demonstrasi.edit');

   Route::put('/update/{id}', [DemonstrasiController::class, 'update'])->name('demonstrasi.update');
   Route::delete('/destroy/{id}', [DemonstrasiController::class, 'destroy'])->name('demonstrasi.destroy');

   // ini taruh PALING BAWAH, biar tidak bentrok
   Route::get('/{id_skema}', [DemonstrasiController::class, 'index'])->name('demonstrasi.index');
});


// Form Asesmen → Pertanyaan Demonstrasi
Route::get('/form-asesmen/pertanyaan-demonstrasi/{id_skema}', 
    [DemonstrasiController::class, 'index']
)->name('formasesmen.pertanyaanDemonstrasi');


/*
|--------------------------------------------------------------------------|
| ROUTE JAWABAN                                                            |
|--------------------------------------------------------------------------|
*/
Route::prefix('jawaban')->group(function () {
    // Tampilkan pertanyaan sesuai skema + jenis soal
    Route::get('/{idSkema}/{jenis}', [JawabanController::class, 'show']);

    // Simpan jawaban
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

// ================== AUTH ==================
use App\Http\Controllers\BandingAsesmenController;
use App\Http\Controllers\FormPraAsesmenController;

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

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('dashboard.asesor');
});

Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');

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

    // ================== PRA ASESMEN ==================
    Route::get('form-pra-assesmen', [FormPraAsesmenController::class, 'index'])
        ->name('form_pra_assesmen');


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

// tampilkan kelompok pekerjaan per skema
// web.php
Route::get('/form-asesmen/{id_skema}/kelompok', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->defaults('jenis', 'lisan')
    ->name('pertanyaan.lisan.kelompok');

// ========== ROUTE PILIHAN GANDA (FLOW ADMIN/ASESI/ASESOR) ==========

// ================== DATA PESERTA UJI ==================
// Halaman daftar peserta
Route::get('datapesertauji', [DataPesertaUjiController::class, 'index'])->name('datapesertauji');

// Detail peserta
Route::get('peserta/{id}', [DataPesertaUjiController::class, 'show'])->name('peserta.show');


// ================== PROFILE ASESOR ==================
Route::prefix('profileasesor')->group(function () {
    Route::get('/', [ProfileAsesorController::class, 'show'])->name('profile.show');
    Route::get('/edit', [ProfileAsesorController::class, 'edit'])->name('profileasesor.edit');
    Route::put('/update', [ProfileAsesorController::class, 'update'])->name('profile.update');
});
Route::get('/form-asesmen/{id_skema}/kelompok-essai', [PertanyaanController::class, 'kelompokPekerjaan'])
    ->defaults('jenis', 'esai')
    ->name('pertanyaan.esai.kelompok');


    Route::get('/form-asesmen/pertanyaan-PG/{id_skema}', [FormAsesmenController::class, 'pertanyaanPG'])
    ->name('formasesmen.pertanyaanPG');

// Routes untuk Opsi Jawaban
Route::prefix('opsi-jawaban')->group(function () {
    Route::post('/store', [OpsiJawabanController::class, 'store'])->name('opsi-jawaban.store');
    Route::post('/store-multiple', [OpsiJawabanController::class, 'storeMultiple'])->name('opsi-jawaban.store-multiple');
    Route::get('/pertanyaan/{id}', [OpsiJawabanController::class, 'getByPertanyaan'])->name('opsi-jawaban.by-pertanyaan');
    Route::put('/update/{id}', [OpsiJawabanController::class, 'update'])->name('opsi-jawaban.update');
    Route::delete('/delete/{id}', [OpsiJawabanController::class, 'destroy'])->name('opsi-jawaban.destroy');
    Route::post('/update-kunci', [OpsiJawabanController::class, 'updateKunciJawaban'])->name('opsi-jawaban.update-kunci');
});

// Routes untuk Pertanyaan Pilihan Ganda
Route::get('/pertanyaan/{id_skema}/kelompok-pg', [PertanyaanController::class, 'kelompokPekerjaan'])
->name('pertanyaan.pg.kelompok')
->defaults('jenis', 'pilihan_ganda');

Route::get('/pertanyaan/pg/kelompok/{id_skema}/{id_pembuatan_pertanyaan?}', [PertanyaanController::class, 'kelompokPekerjaanPG'])
    ->name('pertanyaan.pg.kelompok.withId');

Route::get('/pertanyaan/pg/create', [PertanyaanController::class, 'createPG'])->name('pertanyaan.pg.create');
Route::post('/pertanyaan/pg/store', [PertanyaanController::class, 'storePG'])->name('pertanyaan.pg.store');
Route::get('/pertanyaan/pg/{id_skema}/{id_kelompok}/crud', [PertanyaanController::class, 'crudPG'])->name('pg.crud');

// Tambahan untuk edit/update/destroy
Route::get('/pertanyaan/pg/{id}/edit', [PertanyaanController::class, 'editPG'])->name('pertanyaan.pg.edit');
Route::put('/pertanyaan/pg/{id}', [PertanyaanController::class, 'updatePG'])->name('pertanyaan.pg.update');
Route::delete('/pertanyaan/pg/{id}', [PertanyaanController::class, 'destroyPG'])->name('pertanyaan.pg.destroy');
Route::prefix('pmo')->name('pmo.')->group(function () {


    // CRUD Pertanyaan PMO
    Route::get('/{id_pmo}/crud', [PertanyaanController::class, 'crudPMO'])
        ->name('crud');

    // Simpan pertanyaan baru (store)
   Route::post('/{id_pmo}/pertanyaan', [PertanyaanController::class, 'storePMO'])
    ->name('pertanyaan.store');

    // Input pertanyaan baru (form)
    Route::get('/{id_pmo}/pertanyaan/create', [PertanyaanController::class, 'inputPMO'])
        ->name('pertanyaan.create');

    // Update pertanyaan
    Route::put('/pmo/pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaanPMO'])
    ->name('pmo.pertanyaan.update');

    // Hapus pertanyaan
   Route::delete('/pmo/{id_pmo}/pertanyaan/{id}', [PertanyaanController::class, 'destroyPertanyaanPMO'])
    ->name('pmo.pertanyaan.destroy');

    // Simpan tanggapan PMO
    Route::post('/tanggapan/{id_pmo_pertanyaan}', [PertanyaanController::class, 'tanggapanPMO'])
        ->name('tanggapan');

    // Simpan persetujuan PMO
    Route::post('/{id_pmo}/persetujuan', [PertanyaanController::class, 'persetujuanPMO'])
        ->name('persetujuan');

    // Simpan semua pertanyaan per unit (storePMO)
    Route::post('/{id_pmo}/store', [PertanyaanController::class, 'storePMO'])
        ->name('pertanyaan.pmo.store');
});

// ================== FORM ASESMEN / PMO ==================

// List semua PMO untuk skema
Route::get('/form-asesmen/{id_skema}/pmo', [PertanyaanController::class, 'pertanyaanPMO'])
    ->name('formasesmen.pmo');

// PMO per kelompok (dengan optional id_pembuatan)
Route::get('/form-asesmen/{id_skema}/pmo/kelompok/{id_pembuatan?}', [PertanyaanController::class, 'kelompokPMO'])
    ->name('pertanyaan.pmo.kelompok');

// Input PMO
Route::get('/form-asesmen/{id_skema}/input-pmo', [PertanyaanController::class, 'inputPMO'])
    ->name('form.input.pmo');

// Simpan pertanyaan PMO baru
Route::post('/pmo/{id_pmo}/store', [PertanyaanController::class, 'storePertanyaanPMO'])
    ->name('pmo.pertanyaan.pmo.store');

// TAMPILAN INPUT PMO
Route::get('/pmo/input/{id_skema}', [PertanyaanController::class, 'inputPMO'])->name('input.pmo');

// SIMPAN PERTANYAAN PMO
Route::post('/pmo/{id_pmo}/store', [PertanyaanController::class, 'storePertanyaanPMO'])->name('pmo.pertanyaan.pmo.store');

// Jawaban Asesi PMO
Route::get('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}', [PertanyaanController::class, 'jawabanPMO'])
    ->name('jawaban.pmo');
Route::post('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}', [PertanyaanController::class, 'simpanJawabanPMO'])
    ->name('jawaban.pmo.simpan');

// Tampilkan jawaban PMO (asesor lihat hasil)
Route::get('/jawaban-pmo/{id_skema}/{id_pembuatan}', [PertanyaanController::class, 'tampilJawabanPMO'])
    ->name('jawaban_pmo.form');

// CRUD Pertanyaan PMO
Route::delete('/pmo/{id_pmo}/pertanyaan/{id}', [PertanyaanController::class, 'destroyPertanyaanPMO'])
    ->name('pmo.pertanyaan.destroy');

Route::get('/pmo/{id_pmo}/pertanyaan/{id}/edit', [PertanyaanController::class, 'editPertanyaanPMO'])
    ->name('pmo.pertanyaan.edit');

Route::put('/pmo/pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaanPMO'])
    ->name('pmo.pertanyaan.update');

// ================== DATA PESERTA UJI ==================

Route::get('/data-peserta-uji', [PertanyaanController::class, 'dataPesertaUji'])->name('data.peserta.uji');
Route::get('/detail-jawaban/{skema}/{jenis}', [PertanyaanController::class, 'detailJawaban'])
    ->name('detail.jawaban');

// Halaman mengerjakan demonstrasi
Route::get('/demonstrasi/{id_skema}', [JawabanDemonstrasiController::class, 'show'])
    ->name('demonstrasi.show');

// Simpan jawaban demonstrasi
Route::post('/demonstrasi/store/jawaban', [JawabanDemonstrasiController::class, 'store'])
    ->name('demonstrasi.storeJawaban');

    Route::get('/pmo/kelompok/{id_skema}/{id_pembuatan?}', [PertanyaanController::class, 'kelompokPMO'])
     ->name('pertanyaan.pmo.kelompok');
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
