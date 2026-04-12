@extends('master')
@section('title', 'Dashboard Asesi')
@section('konten')
    <div class="container-fluid px-4 py-4">
        <h1 class="display-6 fw-bold text-dark">Selamat Datang, {{ Auth::user()->name }}</h1>
        <p class="text-secondary">Silakan akses menu di sidebar untuk melanjutkan.</p>
    </div>
@endsection