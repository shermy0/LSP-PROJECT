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
use App\Http\Controllers\BandingAsesmenController;
use App\Http\Controllers\FormPraAsesmenController;
use App\Http\Controllers\Asesi\AsesmenMandiriController as AsesiAsesmenMandiriController;
use App\Http\Controllers\Asesor\AsesmenMandiriController as AsesorAsesmenMandiriController;
use App\Models\UnitKompetensi;
use App\Models\Asesi;
use App\Models\Asesor;

/*
|--------------------------------------------------------------------------
| REDIRECT DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN & REGISTER)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

/*
|--------------------------------------------------------------------------
| PUBLIC / STATIC VIEWS
|--------------------------------------------------------------------------
*/
Route::get('/asesi', fn() => view('asesi.index'))->name('index-asesi');
Route::get('/asesmen', fn() => view('asesi.asesmen'))->name('asesmen');
Route::get('/asesmen2', fn() => view('asesi.asesmen2'))->name('asesmen2');
Route::get('/asesmen3', fn() => view('asesi.asesmen3'))->name('asesmen3');
Route::get('/index', fn() => view('asesor.index'))->name('index');
Route::get('/verifasesmen', fn() => view('asesor.verifasesmen'))->name('verifasesmen');
Route::get('/verifasesmen2', fn() => view('asesor.verifasesmen2'))->name('verifasesmen2');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | LOGOUT
    |----------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    /*
    |----------------------------------------------------------------------
    | DASHBOARD
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('dashboard.asesor');
    Route::get('/dashboard/asesor', [DashboardController::class, 'asesor'])->name('asesor.dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    });

    Route::middleware('role:asesi')->group(function () {
        Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');
    });

    /*
    |----------------------------------------------------------------------
    | FORM PERENCANAAN & MAPA01
    |----------------------------------------------------------------------
    */
    Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
    Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');

    Route::prefix('form-perencanaan')->group(function () {
        Route::get('/mapa01', [MapaController::class, 'create'])->name('form.mapa01');
        Route::get('/mapa01/kode-unit/{skema_id}', [MapaController::class, 'kodeUnit'])->name('form.mapa01.kodeunit');
        Route::get('/mapa01/{skema_id}/kelompok/{kelompok_id}/tambah-unit', [MapaController::class, 'tambahUnit'])->name('form.mapa01.tambahunit');
        Route::post('/mapa01/{skema_id}/kelompok/{kelompok_id}/simpan-unit', [MapaController::class, 'simpanUnit'])->name('form.mapa01.simpanunit');
        Route::delete('/mapa01/{skema_id}/hapus-unit/{id}', [MapaController::class, 'hapusUnit'])->name('form.mapa01.hapusunit');
        Route::post('/{skema_id}/tambah-kelompok', [MapaController::class, 'tambahKelompok'])->name('form.mapa01.tambahKelompok');
        Route::delete('/{skema_id}/hapus-kelompok/{kelompok_id}', [MapaController::class, 'hapusKelompok'])->name('form.mapa01.hapusKelompok');
        Route::get('/get-skema/{id}', [MapaController::class, 'getSkema']);
        Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');
        Route::get('/mapa01/konfirmasi/{skema_id}', [MapaController::class, 'index'])->name('form.mapa01.konfirmasi');
        Route::get('/mapa01/edit-unit/{skema_id}/{id}', [MapaController::class, 'editUnit'])->name('form.mapa01.editunit');
        Route::put('/mapa01/update-unit/{skema_id}/{id}', [MapaController::class, 'updateUnit'])->name('form.mapa01.updateunit');
    });

    Route::get('/get-unit/{id}', [MapaController::class, 'getUnit'])->name('form.mapa01.getunit');
    Route::get('/search-unit', [MapaController::class, 'searchUnit'])->name('form.mapa01.searchunit');
    Route::get('/get-skema/{id}', [PermohonanController::class, 'getSkema'])->name('get.skema');

    /*
    |----------------------------------------------------------------------
    | FORM ASESMEN
    |----------------------------------------------------------------------
    */
    Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');
    Route::get('/asesi/formasesmen', [FormAsesmenController::class, 'asesi'])->name('asesi.formasesmen');
    Route::get('/form-asesmen/{id_skema}', [FormAsesmenController::class, 'showSkema'])->name('formasesmen.show');
    Route::get('/pembuatan/{id_pembuatan}', [FormAsesmenController::class, 'showPembuatan'])->name('pembuatan.show');

    // Skema khusus
    Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');
    Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');
    Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');
    Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');
    Route::get('/juniortechnicalsupport_asesi', [FormAsesmenController::class, 'juniortechnicalsupport_asesi'])->name('formasesmen.juniortechnicalsupport_asesi');
    Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');
    Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

    /*
    |----------------------------------------------------------------------
    | PERTANYAAN - UMUM
    |----------------------------------------------------------------------
    */
    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');

    /*
    |----------------------------------------------------------------------
    | PERTANYAAN - ESAI
    |----------------------------------------------------------------------
    */
    Route::get('/formasesmen/{id_skema}/esai', [FormAsesmenController::class, 'pertanyaanEsai'])->name('pertanyaan.esai');
    Route::get('/formasesmen/pertanyaan-esai/create', [FormAsesmenController::class, 'createPertanyaanEsai'])->name('pertanyaan.esai.create.form');
    Route::get('/form-asesmen/pertanyaan-esai', [FormAsesmenController::class, 'pertanyaanEsai'])->name('formasesmen.pertanyaanEsai.noSkema');
    Route::get('/form-asesmen/pertanyaan-esai/{id_skema}', [FormAsesmenController::class, 'pertanyaanEsai'])->name('formasesmen.pertanyaanEsai');
    Route::get('/pertanyaan/esai/create', [PertanyaanController::class, 'createEsai'])->name('pertanyaan.esai.create');
    Route::post('/form-asesmen/pertanyaan-esai/store', [PertanyaanController::class, 'storeEsai'])->name('pertanyaan.esai.store');
    Route::get('/esai/{id_skema}/{id_kelompok}', [PertanyaanController::class, 'crudEsai'])->name('esai.crud');
    Route::get('/pertanyaan/esai/{id_pertanyaan}/edit', [PertanyaanController::class, 'editPertanyaanEsai'])->name('pertanyaan.esai.edit');
    Route::put('/pertanyaan/esai/{id_pertanyaan}/update', [PertanyaanController::class, 'updatePertanyaanEsai'])->name('pertanyaan.esai.update');
    Route::delete('/pertanyaan/esai/{id_pertanyaan}/delete', [PertanyaanController::class, 'deletePertanyaanEsai'])->name('pertanyaan.esai.delete');
    Route::get('/form-asesmen/pertanyaan-esai//kelompok/{id_skema}', [PertanyaanController::class, 'kelompokPekerjaan'])
        ->defaults('jenis', 'esai')
        ->name('pertanyaan.esai.kelompok');

   /*
    |----------------------------------------------------------------------
    | PERTANYAAN - LISAN
    |----------------------------------------------------------------------
    */
    Route::get('/form-asesmen/{id_skema}/lisan', [PertanyaanController::class, 'pertanyaanLisan'])->name('pertanyaan.lisan');
    Route::get('/form-asesmen/kelompok-lisan/{id_skema}', [PertanyaanController::class, 'kelompokLisan'])->name('kelompok.lisan');
    Route::get('/lisan/input/{id_skema}', [PertanyaanController::class, 'inputLisan'])->name('input.lisan');
    Route::post('/lisan/store/{id_skema}', [PertanyaanController::class, 'storePertanyaanLisan'])->name('lisan.store.pertanyaan');
    Route::get('/lisan/{id_skema}/crud', [PertanyaanController::class, 'crudLisan'])->name('lisan.crud');
    Route::get('/lisan/{id}/edit', [PertanyaanController::class, 'editLisan'])->name('lisan.edit');
    Route::put('/lisan/{id}', [PertanyaanController::class, 'updateLisan'])->name('lisan.update');
    Route::delete('/lisan/{id}', [PertanyaanController::class, 'destroyLisan'])->name('lisan.destroy');
    Route::delete('/lisan/set/{id_pembuatan}', [PertanyaanController::class, 'destroySetLisan'])->name('lisan.set.destroy');
    Route::get('/form-asesmen/pertanyaan-lisan/{id_skema}', [FormAsesmenController::class, 'pertanyaanLisan'])->name('formasesmen.pertanyaanLisan');

    Route::get('/lisan/hasil/{id_skema}', [PertanyaanController::class, 'hasilKelompokLisan'])->name('lisan.hasil.kelompok');
    Route::get('/lisan/hasil/{id_skema}/{id_pembuatan}/{id_kelompok}', [PertanyaanController::class, 'pilihAsesiLisan'])->name('lisan.pilih.asesi');
    Route::get('/lisan/hasil/{id_skema}/{id_pembuatan}/{id_kelompok}/{id_asesi}', [PertanyaanController::class, 'inputJawabanLisan'])->name('lisan.input.jawaban');
    Route::post('/lisan/jawaban/{id_skema}/{id_pembuatan}/{id_asesi}', [PertanyaanController::class, 'simpanJawabanLisan'])->name('lisan.simpan.jawaban');

    /*
    |----------------------------------------------------------------------
    | PERTANYAAN - PILIHAN GANDA (PG)
    |----------------------------------------------------------------------
    */
    Route::get('/form-asesmen/pertanyaan-PG/{id_skema}', [FormAsesmenController::class, 'pertanyaanPG'])->name('formasesmen.pertanyaanPG');
    Route::get('/pertanyaan/pg/create', [PertanyaanController::class, 'createPG'])->name('pertanyaan.pg.create');
    Route::post('/pertanyaan/pg/store', [PertanyaanController::class, 'storePG'])->name('pertanyaan.pg.store');
    Route::get('/pertanyaan/pg/{id_skema}/{id_kelompok}/crud', [PertanyaanController::class, 'crudPG'])->name('pg.crud');
    Route::get('/pertanyaan/pg/{id}/edit', [PertanyaanController::class, 'editPG'])->name('pertanyaan.pg.edit');
    Route::put('/pertanyaan/pg/{id}', [PertanyaanController::class, 'updatePG'])->name('pertanyaan.pg.update');
    Route::delete('/pertanyaan/pg/{id}', [PertanyaanController::class, 'destroyPG'])->name('pertanyaan.pg.destroy');
    Route::get('/pertanyaan/{id_skema}/kelompok-pg', [PertanyaanController::class, 'kelompokPekerjaanPG'])
        ->name('pertanyaan.pg.kelompok')
        ->defaults('jenis', 'pilihan_ganda');
    Route::get('/pertanyaan/pg/kelompok/{id_skema}/{id_pembuatan_pertanyaan?}', [PertanyaanController::class, 'kelompokPekerjaanPG'])
        ->name('pertanyaan.pg.kelompok.withId');

    /*
    |----------------------------------------------------------------------
    | OPSI JAWABAN
    |----------------------------------------------------------------------
    */
    Route::prefix('opsi-jawaban')->group(function () {
        Route::post('/store', [OpsiJawabanController::class, 'store'])->name('opsi-jawaban.store');
        Route::post('/store-multiple', [OpsiJawabanController::class, 'storeMultiple'])->name('opsi-jawaban.store-multiple');
        Route::get('/pertanyaan/{id}', [OpsiJawabanController::class, 'getByPertanyaan'])->name('opsi-jawaban.by-pertanyaan');
        Route::put('/update/{id}', [OpsiJawabanController::class, 'update'])->name('opsi-jawaban.update');
        Route::delete('/delete/{id}', [OpsiJawabanController::class, 'destroy'])->name('opsi-jawaban.destroy');
        Route::post('/update-kunci', [OpsiJawabanController::class, 'updateKunciJawaban'])->name('opsi-jawaban.update-kunci');
    });

    /*
    |----------------------------------------------------------------------
    | TANDA TANGAN ASESOR
    |----------------------------------------------------------------------
    */
    Route::get('/tanda_tangan_asesmen/{id_skema}/{id_pembuatan_pertanyaan}', [PertanyaanController::class, 'formTTDAsesor'])->name('tanda.tangan.asesmen');
    Route::post('/tanda_tangan_asesmen/{id_skema}/{id_pembuatan_pertanyaan}/simpan', [PertanyaanController::class, 'simpanTTDAsesor'])->name('tanda.tangan.asesmen.simpan');

    /*
    |----------------------------------------------------------------------
    | PMO (FR.IA.03)
    |----------------------------------------------------------------------
    */

    // PMO prefix group
    Route::prefix('pmo')->name('pmo.')->group(function () {
        Route::get('/formasesmen/pertanyaan-pmo/{id_skema}', [FormAsesmenController::class, 'pertanyaanPMO'])->name('formasesmen.pertanyaanPMO');
        Route::get('/{id_pmo}/crud', [PertanyaanController::class, 'crudPMO'])->name('crud');
        Route::post('/{id_pmo}/pertanyaan', [PertanyaanController::class, 'storePMO'])->name('pertanyaan.store');
        Route::get('/{id_pmo}/pertanyaan/create', [PertanyaanController::class, 'inputPMO'])->name('pertanyaan.create');
        Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaanPMO'])->name('pertanyaan.update');
        Route::delete('/{id_pmo}/pertanyaan/{id}', [PertanyaanController::class, 'destroyPertanyaanPMO'])->name('pertanyaan.destroy');
        Route::post('/tanggapan/{id_pmo_pertanyaan}', [PertanyaanController::class, 'tanggapanPMO'])->name('tanggapan');
        Route::post('/{id_pmo}/persetujuan', [PertanyaanController::class, 'persetujuanPMO'])->name('persetujuan');
        Route::post('/{id_pmo}/store', [PertanyaanController::class, 'storePMO'])->name('pertanyaan.pmo.store');
    });

    // PMO main routes
    Route::get('/form-asesmen/{id_skema}/pmo', [PertanyaanController::class, 'pertanyaanPMO'])->name('formasesmen.pmo');
    Route::get('/pmo/kelompok/{id_skema}/{id_pembuatan?}', [PertanyaanController::class, 'pertanyaanPMOKelompok'])->name('pertanyaan.pmo.kelompok');
    Route::get('/form-asesmen/{id_skema}/input-pmo', [PertanyaanController::class, 'inputPMO'])->name('form.input.pmo');
    Route::get('/pmo/input/{id_skema}', [PertanyaanController::class, 'inputPMO'])->name('input.pmo');
    Route::post('/pmo/{id_pmo}/store', [PertanyaanController::class, 'storePertanyaanPMO'])->name('pmo.pertanyaan.pmo.store');
    Route::get('/pmo/{id_pmo}/crud', [PertanyaanController::class, 'crudPMO'])->name('pmo.crud');
    Route::get('/pmo/{id_pmo}/pertanyaan/{id}/edit', [PertanyaanController::class, 'editPertanyaanPMO'])->name('pmo.pertanyaan.edit');
    Route::put('/pmo/pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaanPMO'])->name('pmo.pertanyaan.update');
    Route::delete('/pmo/{id_pmo}/pertanyaan/{id}', [PertanyaanController::class, 'destroyPertanyaanPMO'])->name('pmo.pertanyaan.destroy');
    Route::delete('/pmo/set/{id_pembuatan}', [PertanyaanController::class, 'destroySetPMO'])->name('pmo.set.destroy');

    // Jawaban PMO
    Route::get('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}', [PertanyaanController::class, 'jawabanPMO'])->name('jawaban.pmo');
    Route::post('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}/{id_asesi}', [PertanyaanController::class, 'simpanJawabanPMO'])->name('jawaban.pmo.simpan');
    Route::get('/jawaban-pmo/{id_skema}/{id_pembuatan}', [PertanyaanController::class, 'tampilJawabanPMO'])->name('jawaban_pmo.form');

    // Hasil / Input Jawaban PMO
    Route::get('/pmo/hasil/{id_skema}', [PertanyaanController::class, 'hasilKelompokPMO'])->name('pmo.hasil.kelompok');
    Route::get('/pmo/hasil/{id_skema}/{id_pembuatan}/{id_kelompok}', [PertanyaanController::class, 'pilihAsesiPMO'])->name('pmo.pilih.asesi');
    Route::get('/pmo/hasil/{id_skema}/{id_pembuatan}/{id_kelompok}/{id_asesi}', [PertanyaanController::class, 'inputJawabanPMO'])->name('pmo.input.jawaban');

    /*
    |----------------------------------------------------------------------
    | JAWABAN ASESMEN
    |----------------------------------------------------------------------
    */
    Route::get('/pilih-asesmen', [JawabanController::class, 'index'])->name('asesmen.pilih');

    Route::prefix('jawaban')->group(function () {
        Route::get('/lisan/ttd/{idSkema}', [JawabanController::class, 'ttdLisan'])->name('jawaban.ttd_lisan');
        Route::get('/{idSkema}/{jenis}', [JawabanController::class, 'show'])->name('jawaban.show');
        Route::post('/store', [JawabanController::class, 'store'])->name('jawaban.store');
    });

    /*
    |----------------------------------------------------------------------
    | DEMONSTRASI
    |----------------------------------------------------------------------
    */

    // Route standalone (harus di atas prefix group agar tidak bentrok)
    Route::get('/demonstrasi/create', [DemonstrasiController::class, 'create'])->name('demonstrasi.create.standalone');
    Route::post('/demonstrasi/store', [DemonstrasiController::class, 'store'])->name('demonstrasi.store.standalone');
    Route::get('/demonstrasi/{id_skema}/crud', [DemonstrasiController::class, 'crud'])->name('demonstrasi.crud.standalone');
    Route::get('/demonstrasi/{id}/edit', [DemonstrasiController::class, 'edit'])->name('demonstrasi.edit.standalone');
    Route::put('/demonstrasi/{id}/update', [DemonstrasiController::class, 'update'])->name('demonstrasi.update.standalone');
    Route::delete('/demonstrasi/{id}/delete', [DemonstrasiController::class, 'destroy'])->name('demonstrasi.destroy.standalone');
    Route::get('/form-asesmen/pertanyaan-demonstrasi/{id_skema}', [DemonstrasiController::class, 'index'])->name('formasesmen.pertanyaanDemonstrasi');

    Route::prefix('demonstrasi')->group(function () {
        Route::get('/create-tugas', [DemonstrasiController::class, 'createTugas'])->name('demonstrasi.createTugas');
        Route::post('/store-tugas', [DemonstrasiController::class, 'storeTugas'])->name('demonstrasi.storeTugas');
        Route::post('/store', [DemonstrasiController::class, 'store'])->name('demonstrasi.store');
        Route::get('/kelompok/{id_skema}', [DemonstrasiController::class, 'kelompok'])->name('pertanyaan.demonstrasi.kelompok');
        Route::get('/crud/{id_skema}/{id_kelompok}', [DemonstrasiController::class, 'crud'])->name('demonstrasi.crud');
        Route::get('/edit/{id}', [DemonstrasiController::class, 'edit'])->name('demonstrasi.edit');
        Route::put('/update/{id}', [DemonstrasiController::class, 'update'])->name('demonstrasi.update');
        Route::delete('/destroy/{id}', [DemonstrasiController::class, 'destroy'])->name('demonstrasi.destroy');
        Route::post('/store/jawaban', [JawabanDemonstrasiController::class, 'store'])->name('demonstrasi.storeJawaban');
        Route::get('/{id_skema}', [JawabanDemonstrasiController::class, 'show'])->name('demonstrasi.show');
    });

    /*
    |----------------------------------------------------------------------
    | REKAMAN ASESMEN
    |----------------------------------------------------------------------
    */
    Route::get('/rekap-asesmen/{id_skema?}', [RekamanAsesmenController::class, 'index'])->name('rekap.asesmen');
    Route::get('/rekaman/create/{id_skema}', [RekamanAsesmenController::class, 'create'])->name('rekaman.create');
    Route::post('/rekaman/store', [RekamanAsesmenController::class, 'store'])->name('rekaman.store');
    Route::get('/rekaman/show/{id}', [RekamanAsesmenController::class, 'show'])->name('rekaman.show');

    /*
    |----------------------------------------------------------------------
    | CEKLIS OBSERVASI
    |----------------------------------------------------------------------
    */
    Route::prefix('ceklisobservasi')->group(function () {
        Route::get('/', [CeklisObservasiController::class, 'index'])->name('ceklisobservasi.index');
        Route::get('/data/{skemaId}', [CeklisObservasiController::class, 'loadData'])->name('ceklisobservasi.data');
        Route::post('/store', [CeklisObservasiController::class, 'store'])->name('ceklisobservasi.store');
    });

    /*
    |----------------------------------------------------------------------
    | BANDING ASESMEN
    |----------------------------------------------------------------------
    */
    Route::get('/banding-asesmen', [BandingAsesmenController::class, 'index'])->name('banding.index');
    Route::post('/banding-asesmen', [BandingAsesmenController::class, 'store'])->name('banding.store');
    Route::post('/simpan-asesor', [BandingAsesmenController::class, 'simpanAsesor'])->name('simpan.asesor');

    /*
    |----------------------------------------------------------------------
    | PRA ASESMEN
    |----------------------------------------------------------------------
    */
    Route::get('/form-pra-assesmen', [FormPraAsesmenController::class, 'index'])->name('form_pra_assesmen');

    /*
    |----------------------------------------------------------------------
    | PERMOHONAN ASESI (FR.APL.01)
    |----------------------------------------------------------------------
    */
    Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
        Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
        Route::post('/store', [PermohonanController::class, 'store'])->name('store');
        Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
        Route::post('/store-dokumen', [PermohonanController::class, 'storeDokumen'])->name('storeDokumen');
        Route::get('/menunggu', fn() => view('asesi.permohonan.menunggu'))->name('menunggu');
    });

    /*
    |----------------------------------------------------------------------
    | ASESMEN MANDIRI (FR.APL.02)
    |----------------------------------------------------------------------
    */
    Route::prefix('asesi/asesmen-mandiri')->name('asesi.asesmen_mandiri.')->group(function () {
        Route::get('/form1', [AsesiAsesmenMandiriController::class, 'form1'])->name('form1');
        Route::get('/form2', [AsesiAsesmenMandiriController::class, 'form2'])->name('form2');
        Route::get('/form3', [AsesiAsesmenMandiriController::class, 'form3'])->name('form3');
        Route::get('/waiting', fn() => view('asesi.asesmen_mandiri.waiting'))->name('waiting');
        Route::post('/store', [AsesiAsesmenMandiriController::class, 'store'])->name('store');
        Route::post('/ttd', [AsesiAsesmenMandiriController::class, 'storeTTD'])->name('ttd.store');
        Route::get('/{id}', [AsesiAsesmenMandiriController::class, 'show'])->name('show');
    });

    Route::prefix('asesor/asesmen-mandiri')->name('asesor.asesmen_mandiri.')->group(function () {
        Route::get('/', [AsesorAsesmenMandiriController::class, 'index'])->name('index');
        Route::get('/{asesi}', [AsesorAsesmenMandiriController::class, 'show'])->name('show');
        Route::post('/{asesi}/verifikasi', [AsesorAsesmenMandiriController::class, 'verifikasiStore'])->name('verifikasi.store');
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN - PERMOHONAN (FR.APL.01)
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [Form1AdminController::class, 'index'])->name('index');
            Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
            Route::post('/{id_permohonan}/update', [Form1AdminController::class, 'update'])->name('update');
        });
    });

    Route::post('/admin/permohonan/{id_permohonan}/update', [Form1AdminController::class, 'update'])->name('admin.permohonan.update');

    /*
    |----------------------------------------------------------------------
    | DATA PESERTA UJI
    |----------------------------------------------------------------------
    */
    Route::get('/datapesertauji', [DataPesertaUjiController::class, 'index'])->name('datapesertauji');
    Route::get('/peserta/{id}', [DataPesertaUjiController::class, 'show'])->name('peserta.show');
    Route::get('/data-peserta-uji', [PertanyaanController::class, 'dataPesertaUji'])->name('data.peserta.uji');
    Route::get('/detail-jawaban/{skema}/{jenis}', [PertanyaanController::class, 'detailJawaban'])->name('detail.jawaban');

    /*
    |----------------------------------------------------------------------
    | PROFILE ASESOR
    |----------------------------------------------------------------------
    */
    Route::prefix('profileasesor')->group(function () {
        Route::get('/', [ProfileAsesorController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileAsesorController::class, 'edit'])->name('profileasesor.edit');
        Route::put('/update', [ProfileAsesorController::class, 'update'])->name('profile.update');
    });
    // ================== ASESOR LIHAT JAWABAN ASESI ==================
    Route::get('/asesor/skema', [JawabanController::class, 'indexSkema'])->name('asesor.skema.index');
    Route::get('/asesor/skema/{id_skema}/jenis', [JawabanController::class, 'listJenis'])->name('asesor.skema.jenis');
    Route::get('/asesor/skema/{id_skema}/jenis/{jenis}/asesi', [JawabanController::class, 'listAsesi'])->name('asesor.skema.jenis.asesi');
    Route::get('/asesor/skema/{id_skema}/jenis/{jenis}/asesi/{id_asesi}', [JawabanController::class, 'viewJawaban'])->name('asesor.skema.jenis.asesi.jawaban');
    Route::post('/asesor/pencapaian/store', [JawabanController::class,'storePencapaian']) ->name('asesor.pencapaian.store');

    // ================== ASESOR LIHAT JAWABAN ASESI ==================
    Route::get('/asesor/skema', [JawabanController::class, 'indexSkema'])->name('asesor.skema.index');
    Route::get('/asesor/skema/{id_skema}/jenis', [JawabanController::class, 'listJenis'])->name('asesor.skema.jenis');
    Route::get('/asesor/skema/{id_skema}/jenis/{jenis}/asesi', [JawabanController::class, 'listAsesi'])->name('asesor.skema.jenis.asesi');
    Route::get('/asesor/skema/{id_skema}/jenis/{jenis}/asesi/{id_asesi}', [JawabanController::class, 'viewJawaban'])->name('asesor.skema.jenis.asesi.jawaban');
    Route::post('/asesor/pencapaian/store', [JawabanController::class,'storePencapaian']) ->name('asesor.pencapaian.store');

    /*
    |----------------------------------------------------------------------
    | Ceklis Observasi
    |----------------------------------------------------------------------
    */
   // Pilih asesi untuk skema tertentu (skema sudah ditentukan)
    Route::get('/ceklis-observasi/pilih/{id_skema}', [CeklisObservasiController::class, 'pilihAsesi'])->name('ceklisobservasi.pilih');

    // Halaman form ceklis observasi (dengan parameter id_asesi & id_skema)
    Route::get('/ceklis-observasi', [CeklisObservasiController::class, 'index'])->name('ceklisobservasi.index');

    // Proses simpan data
    Route::post('/ceklis-observasi', [CeklisObservasiController::class, 'store'])->name('ceklisobservasi.store');

    // Load data KUK berdasarkan skema (AJAX)
    Route::get('/ceklisobservasi/data/{skemaId}', [CeklisObservasiController::class, 'loadData'])->name('ceklisobservasi.data');

    Route::get('/ceklis-observasi/tandatangan/{id}', [CeklisObservasiController::class, 'tandatangan'])->name('ceklisobservasi.tandatangan');
    Route::post('/ceklis-observasi/tandatangan', [CeklisObservasiController::class, 'storeTandatangan'])->name('ceklisobservasi.storeTandatangan'); 
    Route::get('/ceklis-observasi/tandatangan/{id_skema}/{id_asesi}', [CeklisObservasiController::class, 'tandatanganBySkemaAsesi']) ->name('ceklisobservasi.tandatangan.bySkemaAsesi');
    Route::get('/ttd/asesor/{filename}', [App\Http\Controllers\CeklisObservasiController::class, 'showTtdAsesor'])->name('ttd.asesor');
}); // end middleware auth
