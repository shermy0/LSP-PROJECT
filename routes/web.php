<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\FormAsesmenController;
use App\Http\Controllers\PertanyaanController;

// Edit & Update
Route::get('/pertanyaan/esai/{id}/edit', [PertanyaanController::class, 'editEsai'])->name('pertanyaan.esai.edit');
Route::put('/pertanyaan/esai/{id}', [PertanyaanController::class, 'updateEsai'])->name('pertanyaan.esai.update');

// Hapus
Route::delete('/pertanyaan/esai/{id}', [PertanyaanController::class, 'destroyEsai'])->name('pertanyaan.esai.destroy');


// Form input esai via query string (jumlah & id_skema)
Route::get('/pertanyaan/esai/create', [PertanyaanController::class, 'createEsai'])
    ->name('pertanyaan.esai.create'); // <-- gunakan ini di Blade

// Form Asesmen → pilih skema → input esai (dynamic berdasarkan id_skema)
Route::get('/form-asesmen/pertanyaan-esai/{id_skema}', [FormAsesmenController::class, 'pertanyaanEsai'])
    ->name('formasesmen.pertanyaanEsai');

/*
|--------------------------------------------------------------------------|
| ROUTE PERTANYAAN                                                         |
|--------------------------------------------------------------------------|
*/

// CRUD Esai
Route::get('/esai-crud', [PertanyaanController::class, 'crudEsai'])->name('esai.crud');

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
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
