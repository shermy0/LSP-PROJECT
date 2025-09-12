@extends('master')

@section('title', 'FR.APL.04 - Permohonan Sertifikasi Kompetensi')

@section('konten')
<div class="container mt-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Alert ditolak -->
        <div class="alert d-flex align-items-center" style="background-color:#f8d7da; color:#842029;">
            <i class="bi bi-exclamation-diamond-fill me-2"></i>
            <strong>Permohonan Anda Ditolak</strong>
        </div>

        <!-- Alasan -->
        <div class="border rounded-3 p-3 mb-4">
            <p class="fw-semibold mb-2">Alasan :</p>
            <ul class="mb-0">
                <li>Dokumen yang lampirkan tidak sah</li>
                <li>Dokumen yang lampirkan tidak jelas (blur)</li>
            </ul>
        </div>

        <!-- Tombol -->
        <div class="text-end">
            <a href="{{ route('asesi.permohonan.form1') }}" class="btn text-white px-4" style="background-color:#041562;">
                Isi ulang permohonan
            </a>
        </div>

    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
