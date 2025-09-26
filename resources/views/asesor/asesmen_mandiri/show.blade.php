@extends('master')

@section('title', 'Detail Asesmen Mandiri')

@section('konten')
<div class="container mt-4">
    <h2 class="fw-bold">Detail Asesmen Mandiri</h2>
    <p class="text-muted">FR.APL.02 - Asesi</p>

    <div class="card p-4">
        <h5>Nama Skema: {{ $asesmen->nama_skema ?? '-' }}</h5>
        <p>Tanggal: {{ $asesmen->created_at ?? '-' }}</p>
        <p>Status: {{ $asesmen->status ?? 'Belum diisi' }}</p>
    </div>

    <a href="{{ route('asesi.form_pra_asesmen') }}" class="btn btn-secondary mt-3">⬅ Kembali</a>
</div>
@endsection
