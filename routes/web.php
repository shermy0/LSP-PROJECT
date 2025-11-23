<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
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

// ============================
// Halaman Utama
// ============================
Route::get('/', function () {
    return view('welcome');
});

// ============================
// Login & Register
// ============================
// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Pilih Role Register
Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

// Register Asesi
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

// Register Asesor
Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');

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
Route::get('/mapa02/{skema_id}', [Mapa02Controller::class, 'showMapa02'])->name('form.mapa02');
Route::get('/mapa02/{skema_id}/asesor', [Mapa02Controller::class, 'showMapa02Asesor'])
    ->name('form.mapa02.asesor');

// Halaman utama laporan (FR.AK.05)
Route::get('/laporan/{skema_id}', [LaporanController::class, 'showLaporan'])->name('laporan.show');
Route::get('/laporan_asesor/{skema_id}', [LaporanController::class, 'showLaporanAsesor'])->name('form_perencanaan.laporan_asesmen.laporan_asesor');
Route::get('/laporan/{skema_id}/asesi/{asesor_id}', [LaporanController::class, 'getAsesiByAsesor'])->name('laporan.getAsesi');
Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan_asesor.store');

// ============================
// Meninjau Asesmen
// ============================
Route::get('/ninjau_asesemen/{id_skema}', [MeninjauAsesmenController::class, 'showNinjauAsesmen'])
    ->name('form_perencanaan.ninjau_asesemen');

Route::get('/ninjau-asesmen-asesor/{id_skema}', [MeninjauAsesmenController::class, 'showAsesor'])
    ->name('form_perencanaan.ninjau_asesmen_asesor.view');

Route::post('/meninjau-asesmen/store', [MeninjauAsesmenController::class, 'store'])
    ->name('meninjau_asesmen.store');

Route::post('/ninjau-asesmen-asesor/{asesor_id}/simpan-persetujuan', [MeninjauAsesmenController::class, 'simpanPersetujuan'])
    ->name('ninjau_asesmen_asesor.simpan');

// simpan dan lanjut
Route::post('/ninjau-asesmen-asesor', [MeninjauAsesmenController::class, 'simpanLanjut'])
    ->name('ninjau_asesmen_asesor');

Route::get('/ninjau-asesmen-asesor/{asesor_id}', [MeninjauAsesmenController::class, 'showAsesor'])
    ->name('ninjau_asesmen_asesor.view');

Route::get('/get-asesor/{skema_id}', [MeninjauAsesmenController::class, 'getAsesor']);

Route::get('/ninjau_asesemen/ninjau-asesmen-asesor', [MeninjauAsesmenController::class, 'showAsesor'])
    ->name('ninjau_asesmen_asesor.show');

Route::post('/ninjau_asesemen/ninjau-asesmen-asesor', [MeninjauAsesmenController::class, 'simpanLanjut'])
    ->name('ninjau_asesmen_asesor.store');

    //MODIFIKASI
    Route::get('/mapa01/modifikasi/{skema_id}', [ModifikasiController::class, 'index'])->name('form.mapa01.modifikasi');
    // Halaman utama laporan (FR.AK.05)
// Route::get('/laporan/{skema_id}', [LaporanController::class, 'showLaporan'])->name('laporan.show');
// Route::get('/laporan/{skema_id}/asesi/{asesor_id}', [LaporanController::class, 'getAsesiByAsesor'])->name('laporan.getAsesi');
// Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan_asesor.store');
    
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



// Route::post('/mapa01/konfirmasi/{skema_id}/simpan', [KonfirmasiController::class, 'simpanKonfirmasi'])
//     ->name('form.mapa01.konfirmasi.simpan');

    // Edit & update unit
    Route::get('/mapa01/edit-unit/{skema_id}/{id}', [Mapa01Controller::class, 'editUnit'])->name('form.mapa01.editunit');
    Route::put('/mapa01/update-unit/{skema_id}/{id}', [Mapa01Controller::class, 'updateUnit'])->name('form.mapa01.updateunit');
    // ============================
// MAPA 01 & MAPA 02
// ============================
// Route::get('/mapa02', [PerencanaanController::class, 'mapa02'])->name('form.mapa02');

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
// MAPA 02 (lama, sementara dikomentari)
// ============================
// Route::get('/mapa02', [PerencanaanController::class, 'mapa02'])->name('form.mapa02');
// Route::get('/mapa02', [SkemaController::class, 'showForm'])->name('mapa02.show');
// Route::get('/mapa02/skema/{skemaId}/kelompok', [Mapa01Controller::class, 'getKelompokBySkema']);
// Route::get('mapa02/mapa02-asesor', [PerencanaanController::class, 'mapa02'])->name('mapa02_asesor.show');
// Route::post('mapa02/mapa02-asesor', [PerencanaanController::class, 'simpanLanjutmapa02'])->name('mapa02_asesor');
// Route::get('/mapa02/skema/{skemaId}/instrumen', [SkemaController::class, 'getInstrumenBySkema']);
// Route::get('/mapa02/skema/{skemaId}/asesor', [SkemaController::class, 'getAsesor']);
// Route::post('/instrumen/simpan-potensi', [InstrumenController::class, 'simpanPotensi'])->name('instrumen.simpanPotensi');
// Route::get('/mapa02/skema/{skemaId}/units', [SkemaController::class, 'getUnits']);
// Route::get('/asesor/search', [AsesorController::class, 'search'])->name('asesor.search');

// Halaman MAPA02 default (tampilkan semua skema)
Route::get('/mapa02', [Mapa02Controller::class, 'index'])->name('mapa02.index');

// Halaman MAPA02 per skema
Route::get('/mapa02/{id_skema}', [Mapa02Controller::class, 'showMapa02'])->name('form.mapa02');

// AJAX
// Route::get('/mapa02/skema/{skemaId}/asesor', [Mapa02Controller::class, 'getAsesor'])->name('mapa02.getAsesor');
// Route::get('/mapa02/skema/{skemaId}/asesi/{asesorId}', [Mapa02Controller::class, 'getAsesi'])->name('mapa02.getAsesi');
// Route::get('/mapa02/skema/{skemaId}/units', [Mapa02Controller::class, 'getUnits'])->name('mapa02.getUnits');

// Simpan jawaban instrumen
Route::post('/mapa02/instrumen/simpan-potensi', [Mapa02Controller::class, 'simpanInstrumen'])
    ->name('mapa02.simpanInstrumen');

Route::get('/get-unit/{skema_id}', [Mapa01Controller::class, 'getUnitsBySkema']);


Route::get('/get-unit/{id}', [Mapa01Controller::class, 'getUnit'])->name('form.mapa01.getunit');
Route::get('/search-unit', [Mapa01Controller::class, 'searchUnit'])->name('form.mapa01.searchunit');


// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('fr_va_pdf/preview/{skema_id}/{periode}', [PerencanaanController::class, 'preview'])
        ->name('form_perencanaan.fr_va_pdf');

    Route::get('fr_va_pdf/download/{skema_id}/{periode}', [PerencanaanController::class, 'download'])
        ->name('form_perencanaan.pdf_frva');   
});
// ============================
// Meninjau Asesmen
// ============================
// Route::get('/ninjau_asesemen', [SkemaController::class, 'ninjau_asesemen'])->name('ninjau_asesemen');
// Route::get('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'ninjauAsesmenAsesor'])->name('ninjau_asesmen_asesor.show');
// Route::post('/ninjau_asesemen/ninjau-asesmen-asesor', [PerencanaanController::class, 'simpanLanjut'])->name('ninjau_asesmen_asesor.store');

// ============================
// Laporan
// ============================
// Halaman daftar laporan asesmen
// Route::get('/laporan-asesor', [PerencanaanController::class, 'laporan'])
//     ->name('laporan_asesor.index');
// // Simpan catatan asesmen
// Route::post('/laporan-asesor', [PerencanaanController::class, 'simpanLanjutLaporan'])
//     ->name('laporan_asesor.store');
// // Halaman laporan umum (kalau memang perlu dari SkemaController)
// Route::get('/laporan', [SkemaController::class, 'laporan'])
//     ->name('laporan
// Route::get('laporan/{skema_id}/asesi/{asesor_id}', 
//     [LaporanController::class, 'getAsesiByAsesor']
// );



// Ajax ambil asesor & asesi
Route::get('/get-asesor/{skemaId}', [SkemaController::class, 'getAsesor']);
Route::get('/get-asesi/{skemaId}/{asesorId}', [SkemaController::class, 'getAsesi']);

// ============================
// Logout
// ============================
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
