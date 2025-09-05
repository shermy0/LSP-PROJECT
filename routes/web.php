<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('asesi.index');
})->name('index');

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