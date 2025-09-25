@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
    <div class="container">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span>Form Asesmen &gt; <strong>FR.APL.02</strong></span>
        </div>

        <!-- Logo -->
        <div class="logo-box text-center">
            <div class="logo mb-2"></div>
            <h2>Asesmen Mandiri</h2>
        </div>

        <!-- Form -->
        <div class="form-wrapper">
            <div class="form-box">
                <label for="judul">Judul</label>
                <input type="text" id="judul" class="form-control" value="{{ $permohonan->judul_skema ?? '-' }}" readonly>
            </div>

            <div class="form-box">
                <label for="nomor">Nomor</label>
                <input type="text" id="nomor" class="form-control" value="{{ $permohonan->kode_skema ?? '-' }}" readonly>
            </div>

            <div class="form-box">
                <label for="skema">Skema Sertifikasi</label>
                <input type="text" id="skema" class="form-control" value="{{ $permohonan->skema ?? '-' }}" readonly>

            </div>
        </div>

        <!-- Panduan -->
        <div class="guide-box">
            <div class="guide-header">
                <h3>Panduan Asesmen Mandiri</h3>
            </div>

            <div class="step">
                <div class="step-number">1.</div>
                <div class="step-text">Baca setiap pertanyaan/kriteria yang ditampilkan.</div>
            </div>
            <div class="step">
                <div class="step-number">2.</div>
                <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten".</div>
            </div>
            <div class="step">
                <div class="step-number">3.</div>
                <div class="step-text">Jika memilih "Kompeten", unggah bukti pendukung.</div>
            </div>
            <div class="step">
                <div class="step-number">4.</div>
                <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum kirim.</div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="button-box">
            <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-next">Selanjutnya</a>
        </div>
    </div>
@endsection