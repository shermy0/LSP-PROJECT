<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//ASESMEN
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\Asesi\PermohonanController;
use App\Http\Controllers\Admin\Form1AdminController;
use App\Http\Controllers\OpsiJawabanController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\DataPesertaUjiController;
use App\Http\Controllers\ProfileAsesorController;
use App\Http\Controllers\DemonstrasiController;
//PERENCANAAN
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\FormPerencanaan\Mapa01Controller;
use App\Http\Controllers\FormPerencanaan\Mapa02Controller;
use App\Http\Controllers\FormPerencanaan\ModifikasiController;
use App\Http\Controllers\FormPerencanaan\KonfirmasiController;
use App\Http\Controllers\FormPerencanaan\LaporanController;
use App\Http\Controllers\FormPerencanaan\MeninjauAsesmenController;
use App\Http\Controllers\SkemaController;
use App\Models\UnitKompetensi;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\FormPerencanaanController;


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
// Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
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
    // input tugas HARUS lebih dulu sebelum {id_skema}
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
// Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');

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
Route::get('/form/mapa01/{id_skema}/download-all', [Mapa01Controller::class, 'downloadAll'])
    ->name('form.mapa01.downloadAll')
    ->middleware('role:admin'); // ✅ hanya admin
    
Route::get('admin/form-perencanaan/mapa01/{id_skema}/pdf', [Mapa01Controller::class, 'downloadPdfAdmin'])
    ->name('form.mapa01.admin.pdf')
    ->middleware('auth'); // dan cek role admin di method sudah ada

// Untuk admin lihat versi PDF MAPA.01
Route::get('/admin/formperencanaan/mapa01/{id_skema}', [Mapa01Controller::class, 'showMapa01Admin'])
    ->name('admin.mapa01.admin');
Route::get('/admin/formperencanaan/mapa01/pdf/{id_skema}', [Mapa01Controller::class, 'downloadPdfAdmin'])
    ->name('admin.mapa01.pdf');

// 🔹 Admin melihat form MAPA.02
Route::get('/admin/formperencanaan/mapa02/{id_skema}', [Mapa02Controller::class, 'showMapa02Admin'])
    ->name('admin.mapa02.admin')
    ->middleware('auth');

    // 🔹 Admin download versi PDF MAPA.02
Route::get('/admin/formperencanaan/mapa02/pdf/{id_skema}', [Mapa02Controller::class, 'downloadPdfAdmin'])
    ->name('admin.mapa02.pdf')
    ->middleware('auth');

Route::get('/admin/laporan-asesmen/{id_skema}', [LaporanController::class, 'showAdminLaporan'])
    ->name('admin.laporan.admin');

    // 🔹 Admin download versi PDF LAPORAN
Route::get('/admin/formperencanaan/laporan-asesmen/pdf/{id_skema}', [LaporanController::class, 'downloadPdfAdmin'])
    ->name('admin.laporan.pdf')
    ->middleware('auth');


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


// form perencanaan mapa 01
Route::prefix('form-perencanaan')->group(function () {
// ============================
// BUAT NAVIGASI PERFORM, JANGAN OTAK-ATIK!!!
// ============================
    // MAPA01
Route::get('/mapa01/{id_skema}', [Mapa01Controller::class, 'showMapa01'])->name('form.mapa01');
   // MAPA02
Route::get('/mapa02/{skema_id}/asesor', [Mapa02Controller::class, 'showMapa02Asesor'])
    ->name('form.mapa02.asesor');
    
// Halaman MAPA02 per skema
Route::get('/mapa02/{id_skema}', [Mapa02Controller::class, 'showMapa02'])->name('form.mapa02');
Route::post('/mapa02/instrumen/simpan-potensi', [Mapa02Controller::class, 'simpanInstrumen'])
    ->name('mapa02.simpanInstrumen');
// ✅ Penyusun MAPA.02 (pakai KonfirmasiController)
Route::post('/mapa02/{skema_id}/penyusun/simpan', [Mapa02Controller::class, 'storePenyusun'])
    ->name('form.mapa02.penyusun.store');

Route::delete('/mapa02/penyusun/{id}', [Mapa02Controller::class, 'deletePenyusun'])
    ->name('form.mapa02.penyusun.delete');

Route::delete('/mapa02/penyusun/{id}/delete-ttd', [KonfirmasiController::class, 'deleteTtd'])
    ->name('form.mapa02.penyusun.deleteTtd');

Route::get('/mapa02/penyusun/{id}/download-ttd', [KonfirmasiController::class, 'downloadTtd'])
    ->name('form.mapa02.penyusun.downloadTtd');

// Halaman utama laporan (FR.AK.05)
Route::get('/laporan/{skema_id}', [LaporanController::class, 'showLaporan'])->name('laporan.show');
Route::get('/laporan_asesor/{skema_id}', [LaporanController::class, 'showLaporanAsesor'])->name('form_perencanaan.laporan_asesmen.laporan_asesor');
Route::get('/laporan/{skema_id}/asesi/{asesor_id}', [LaporanController::class, 'getAsesiByAsesor'])->name('laporan.getAsesi');
Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan_asesor.store');

Route::post('/laporan/{skema_id}/store', [LaporanController::class, 'store'])
    ->name('laporan.store');


// Halaman laporan asesor (FR.MAPA.01)
Route::get('/laporan_asesor/{skema_id}', [LaporanController::class, 'showLaporanAsesor'])
    ->name('form_perencanaan.laporan_asesmen.laporan_asesor');

// Simpan catatan + tanda tangan asesor ke penyusun_persetujuan
Route::post('/laporan_asesor/{skema_id}/asesor/store', [KonfirmasiController::class, 'storeLaporanAsesor'])
    ->name('form_perencanaan.laporan_asesmen.laporan_asesor.store');

// Hapus TTD
Route::delete('/laporan_asesor/ttd/{id}', [KonfirmasiController::class, 'deleteTtd'])
    ->name('form_perencanaan.laporan_asesmen.ttd.delete');

// Download TTD
Route::get('/laporan_asesor/ttd/{id}/download', [KonfirmasiController::class, 'downloadTtd'])
    ->name('form_perencanaan.laporan_asesmen.ttd.download');

    // ============================
// Meninjau Asesmen
// ============================
Route::get('/ninjau_asesmen/{id_skema}', [MeninjauAsesmenController::class, 'showNinjauAsesmen'])
    ->name('form_perencanaan.ninjau_asesmen');

Route::get('/ninjau-asesmen-asesor/{id_skema}', [MeninjauAsesmenController::class, 'ninjauAsesmenAsesor'])
    ->name('form_perencanaan.ninjau_asesmen_asesor');

// web.php
Route::post('/meninjau-asesmen/store/{id_skema}', [MeninjauAsesmenController::class, 'store'])
    ->name('form_perencanaan.ninjau_asesmen.store');

Route::post('/ninjau-asesmen-asesor/{asesor_id}/simpan-persetujuan', [MeninjauAsesmenController::class, 'simpanPersetujuan'])
    ->name('form_perencanaan.meninjau_asesmen.ninjau_asesmen_asesor.simpan');

// Simpan & lanjut asesmen
Route::post('/ninjau-asesmen-asesor/{id_skema}/simpan', [MeninjauAsesmenController::class, 'simpanLanjut'])
    ->name('form_perencanaan.ninjau_asesmen_asesor.store');


    //MODIFIKASI
    Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');

    // ============================
// END NAVIGASI PERFORM
// ============================
Route::post('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'store'])
     ->name('form.mapa01.modifikasi.store');

Route::post('mapa01/{id_skema}/store', [Mapa01Controller::class, 'storeMapa01'])
    ->name('form.mapa01.store');
Route::post('/mapa01/{skema}/tujuan/{tujuan}/update', [Mapa01Controller::class, 'updateTujuan'])->name('mapa01.tujuan.update');

Route::delete(
    '/form-perencanaan/mapa01/{skema}/tujuan/{tujuan}',
    [Mapa01Controller::class, 'deleteTujuan']
)->name('mapa01.tujuan.delete');

            // Unit per skema & kelompok
Route::get('/mapa01/kode-unit/{skema_id}', [Mapa01Controller::class, 'kodeUnit'])->name('form.mapa01.kodeunit');
    Route::get('/mapa01/{skema_id}/kelompok/{kelompok_id}/tambah-unit', [Mapa01Controller::class, 'tambahUnit'])->name('form.mapa01.tambahunit');
    Route::post('/mapa01/{skema_id}/kelompok/{kelompok_id}/simpan-unit', [Mapa01Controller::class, 'simpanUnit'])->name('form.mapa01.simpanunit');
    Route::delete('/mapa01/{skema_id}/hapus-unit/{id}', [Mapa01Controller::class, 'hapusUnit'])->name('form.mapa01.hapusunit');

    // Kelompok pekerjaan
    Route::post('/mapa01/{skema_id}/tambah-kelompok', [Mapa01Controller::class, 'tambahKelompok'])->name('form.mapa01.tambahKelompok');
    Route::delete('/mapa01/{skema_id}/hapus-kelompok/{kelompok_id}', [Mapa01Controller::class, 'hapusKelompok'])->name('form.mapa01.hapusKelompok');

    // Get skema
    Route::get('/mapa01/get-skema/{id}', [Mapa01Controller::class, 'getSkema'])->name('form.mapa01.getskema');

// Konfirmasi
    Route::get('/mapa01/konfirmasi/{skema_id}', [KonfirmasiController::class, 'konfirmasi'])
        ->name('form.mapa01.konfirmasi');

    Route::post('/mapa01/konfirmasi/{skema_id}', [KonfirmasiController::class, 'store'])
        ->name('form.mapa01.konfirmasi.simpan');

Route::get('mapa01/konfirmasi/ttd/{id}/download', [KonfirmasiController::class, 'downloadTtd'])->name('form.mapa01.konfirmasi.ttd.download');
Route::delete('mapa01/konfirmasi/ttd/{id}/delete', [KonfirmasiController::class, 'deleteTtd'])->name('form.mapa01.konfirmasi.ttd.delete');
// routes/web.php
Route::delete('mapa01/konfirmasi/penyusun/{id}/delete', 
    [KonfirmasiController::class, 'deletePenyusun']
)->name('form.mapa01.konfirmasi.penyusun.delete');

    // Edit & update unit
    Route::get('/mapa01/edit-unit/{skema_id}/{id}', [Mapa01Controller::class, 'editUnit'])->name('form.mapa01.editunit');
    Route::put('/mapa01/update-unit/{skema_id}/{id}', [Mapa01Controller::class, 'updateUnit'])->name('form.mapa01.updateunit');

    // ============================
// FR VA
// ============================
    Route::get('/fr-va/{periode}/{skema_id?}', [PerencanaanController::class, 'frva'])
    ->name('form_perencanaan.fr_va');

Route::get('/fr-va-asesor/{periode}/{skema_id?}', [PerencanaanController::class, 'frVaAsesor'])
    ->name('form_perencanaan.fr_va_asesor');

Route::post('/fr-va-asesor/simpan', [PerencanaanController::class, 'simpanLanjutfrVa'])
    ->name('form_perencanaan.fr_va_asesor.simpan');

Route::post('/formperencanaan/simpan-semua', [PerencanaanController::class, 'simpanSemua'])->name('formperencanaan.simpan_semua');

});


// ============================
// FR VA
// ============================
// Route::get('/fr-va/{periode}', [PerencanaanController::class, 'frVa'])->name('fr_va');
// Route::get('/fr-va-asesor', [PerencanaanController::class, 'frVaAsesor'])->name('fr_va_asesor');
// Route::post('/fr-va-asesor/simpan', [PerencanaanController::class, 'simpanLanjutfrVa'])->name('fr_va_asesor.simpan');


Route::get('/get-unit/{skema_id}', [Mapa01Controller::class, 'getUnitsBySkema']);


Route::get('/get-unit/{id}', [Mapa01Controller::class, 'getUnit'])->name('form.mapa01.getunit');
Route::get('/search-unit', [Mapa01Controller::class, 'searchUnit'])->name('form.mapa01.searchunit');


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
// ================== DASHBOARD ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/asesi/dashboard', [DashboardController::class, 'asesi'])->name('asesi.dashboard');
    Route::get('/asesor/dashboard', [DashboardController::class, 'asesor'])->name('dashboard.asesor');
});

// Route::get('/form-mapa01', [SkemaController::class, 'formMapa01'])->name('form.mapa01');


    // ================== FORM ASESMEN (untuk Asesor) ==================
    // Route::get('/formperencanaan', [PerencanaanController::class, 'index'])->name('formperencanaan');
    Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');
    Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');
    Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');
    Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');
    Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');
    Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');
    Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

    // ================== FORM PERMOHONAN (untuk Asesi) ==================
    Route::prefix('asesi/permohonan')->name('asesi.permohonan.')->group(function () {
        Route::get('/form1', [PermohonanController::class, 'form1'])->name('form1');
        Route::post('/store', [PermohonanController::class, 'store'])->name('store');
        Route::get('/form2', [PermohonanController::class, 'form2'])->name('form2');
        Route::post('/store-dokumen', [PermohonanController::class, 'storeDokumen'])->name('storeDokumen');
    });

    // API get skema & unit kompetensi (AJAX)
    Route::get('/get-skema/{id}', [PermohonanController::class, 'getSkema'])->name('get.skema');

    // ================== ADMIN (FR.APL.01 - Form1) ==================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [Form1AdminController::class, 'index'])->name('index');
            Route::get('/{user_id}', [Form1AdminController::class, 'show'])->name('show');
        });
    });

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

// ================== ROUTE PMO ==================

// CRUD PMO (buat/edit pertanyaan PMO)
Route::prefix('pmo')->name('pmo.')->group(function () {
    Route::get('/create', [PertanyaanController::class, 'createPMO'])->name('create');
    Route::post('/store', [PertanyaanController::class, 'storePMO'])->name('store');
    Route::get('/{id_skema}/{id_kelompok}/crud', [PertanyaanController::class, 'crudPMO'])->name('crud');
    Route::get('/{id}/edit', [PertanyaanController::class, 'editPMO'])->name('edit');
    Route::put('/{id}', [PertanyaanController::class, 'updatePMO'])->name('update');
    Route::delete('/{id}', [PertanyaanController::class, 'destroyPMO'])->name('destroy');
    Route::get('/{id_skema}', [FormAsesmenController::class, 'tampilPMO'])->name('tampil');
});

// ================== FORM ASESMENT PMO ==================

// Halaman utama PMO
Route::get('/form-asesmen/{id_skema}/pmo', 
    [FormAsesmenController::class, 'pertanyaanPMO']
)->name('formasesmen.pertanyaanPMO');

Route::get('/form-asesmen/{id_skema}/pmo', 
    [FormAsesmenController::class, 'pertanyaanPMO']
)->name('formasesmen.pmo');

// Kelompok Pekerjaan PMO
Route::get('/form-asesmen/{id_skema}/kelompok-pmo', 
    [PertanyaanController::class, 'kelompokPekerjaan']
)->name('pertanyaan.pmo.kelompok');

// Input Pertanyaan PMO (INI YANG DIPAKAI)
Route::get('/form-asesmen/{id_skema}/input-pmo', 
    [PertanyaanController::class, 'inputPMO']
)->name('input.pmo');

// Route Jawaban Asesi PMO
Route::get('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}', 
    [PertanyaanController::class, 'jawabanPMO']
)->name('jawaban.pmo');
Route::post('/form-asesmen/{id_skema}/jawaban-pmo/{id_pembuatan}', 
    [FormAsesmenController::class, 'simpanJawabanPMO']
)->name('jawaban.pmo.simpan');

// Tampilkan Jawaban PMO (asesor lihat hasil)
Route::get('/jawaban-pmo/{id_skema}/{id_pembuatan}', 
    [FormAsesmenController::class, 'tampilJawabanPMO']
)->name('jawaban_pmo.form');
Route::get('form-asesmen/{id_skema}/kelompok-pmo', [PertanyaanController::class, 'kelompokPMO'])->name('pertanyaan.pmo.kelompok');
Route::get('/input_PMO', [PertanyaanController::class, 'inputPMO'])->name('input.pmo');

Route::post('/evaluasi/store', [EvaluasiController::class, 'store'])->name('evaluasi.store');
Route::post('/pmo/store', [PertanyaanController::class, 'storePMO'])->name('pmo.store');

Route::get('/data-peserta-uji', [PertanyaanController::class, 'dataPesertaUji'])->name('data.peserta.uji');
Route::get('/detail-jawaban/{skema}/{jenis}', [PertanyaanController::class, 'detailJawaban'])
    ->name('detail.jawaban');