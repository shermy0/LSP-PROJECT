@extends('master')

@section('title', 'Permohonan Belum Diisi')

@section('konten')
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height:70vh;">

    <!-- Card utama -->
    <div class="card shadow-lg border-0 text-center p-5 rounded-4" style="max-width: 600px;">

        <!-- Icon / Ilustrasi -->
        <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow"
                 style="width:80px; height:80px; background: #fff3cd; border:2px solid #ffc107;">
                <span style="font-size:2.2rem;">⚠️</span>
            </div>
        </div>

        <!-- Judul -->
        <h3 class="fw-bold text-warning">Formulir Belum Diisi</h3>
        <p class="text-muted mt-3">
            Asesi <strong>{{ $asesi->nama_lengkap }}</strong> <br>
            (NIK: {{ $asesi->nik }}) belum mengisi <br>
            <span class="fw-semibold text-dark">Form Permohonan Sertifikasi (FR.APL.02)</span>.
        </p>

        <!-- Divider -->
        <hr class="my-4">

        <!-- Tombol -->
        <a href="{{ route('admin.permohonan.index') }}" 
           class="btn btn-outline-warning fw-semibold px-4 py-2 rounded-pill shadow-sm">
            ⬅ Kembali ke Daftar Asesi
        </a>
    </div>
</div>

{{-- Style tambahan --}}
<style>
    body {
        background: #f8f9fa;
    }
    .card {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
