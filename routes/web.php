<?php

use App\Http\Controllers\FormAsesmenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\PertanyaanEsai;


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
Route::get('/pramuniaga', [FormAsesmenController::class, 'pramuniaga'])->name('formasesmen.pramuniaga');

Route::get('/officeadministative', [FormAsesmenController::class, 'officeadministative'])->name('formasesmen.officeadministative');

Route::get('/pemogramanjunior', [FormAsesmenController::class, 'pemogramanjunior'])->name('formasesmen.pemogramanjunior');

Route::get('/juniortechnicalsupport', [FormAsesmenController::class, 'juniortechnicalsupport'])->name('formasesmen.juniortechnicalsupport');

Route::get('/junioroperatordesigngrafis', [FormAsesmenController::class, 'junioroperatordesigngrafis'])->name('formasesmen.junioroperatordesigngrafis');

Route::get('/akuntansikeuanganII', [FormAsesmenController::class, 'akuntansikeuanganII'])->name('formasesmen.akuntansikeuanganII');

// Form Perencanaan untuk Asesor
Route::get('/formasesmen', [FormAsesmenController::class, 'index'])->name('formasesmen');

// form assesmen
Route::get('/form-asesmen/pertanyaan-esai', [FormAsesmenController::class, 'pertanyaanEsai'])->name('pertanyaan.esai');
Route::post('/form-asesmen/pertanyaan-esai/store', [FormAsesmenController::class, 'storeEsai'])->name('pertanyaan.esai.store');
Route::post('/form-asesmen/pertanyaan-esai/delete', [FormAsesmenController::class, 'deleteEsai'])->name('pertanyaan.esai.delete');



// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});


//login
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

// Dashboard Asesi
Route::get('/dashboard/asesi', [DashboardController::class, 'asesi'])->name('dashboard.asesi');


// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
