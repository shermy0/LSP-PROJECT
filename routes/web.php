<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;



Route::get('/', function () {
    return view('welcome');
});

//login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register-role', [AuthController::class, 'showRegisterRole'])->name('register.role');

//register
Route::get('/register/asesi', [RegisterController::class, 'showAsesiForm'])->name('register.asesi');
Route::post('/register/asesi', [RegisterController::class, 'storeAsesi'])->name('register.asesi.store');

Route::get('/register/asesor', [RegisterController::class, 'showAsesorForm'])->name('register.asesor');
Route::post('/register/asesor', [RegisterController::class, 'storeAsesor'])->name('register.asesor.store');



//dashboard
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Asesor\DashboardController as AsesorDashboard;
use App\Http\Controllers\Asesi\DashboardController as AsesiDashboard;

// Asesor dashboard
Route::get('/asesor/dashboard', [AsesorDashboard::class, 'index'])->name('asesor.dashboard');

