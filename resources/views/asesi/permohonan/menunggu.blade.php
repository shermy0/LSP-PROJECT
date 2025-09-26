@extends('master')

@section('title', 'Menunggu Verifikasi Admin')

@section('konten')
<div class="container d-flex flex-column align-items-center justify-content-center text-center" style="min-height:75vh;">
    
    <!-- Gambar -->
    <img src="{{ asset('assets/poto/menunggu.png') }}" 
         alt="Menunggu Verifikasi" 
         class="img-fluid mb-4" 
         style="max-width:320px;">

    <!-- Teks -->
    <h3 class="fw-bold text-dark mb-2">Menunggu Verifikasi Admin</h3>
    <p class="text-muted mb-4" style="max-width:500px;">
        Permohonan Anda telah diajukan dan sedang dalam proses verifikasi oleh admin.
        Mohon tunggu konfirmasi selanjutnya.
    </p>

    <!-- Tombol -->
    <a href="{{ route('asesi.form_pra_asesmen') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
        ← Kembali
    </a>
</div>

{{-- Style tambahan --}}
<style>
    .btn-primary {
        background-color: #041562;
        border: none;
    }
    .btn-primary:hover {
        background-color: #062789;
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
</style>
@endsection
