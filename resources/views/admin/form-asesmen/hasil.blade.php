@extends('master')

@section('konten')

<div class="container mt-4">

    <h1 class="fw-bold mb-3">Hasil Asesmen</h1>

    <div class="mb-4">
        <p class="mb-0"><strong>Nama Asesi:</strong> {{ $asesi->nama_lengkap ?? '-' }}</p>
        <p class="mb-0"><strong>Email:</strong> {{ $asesi->email ?? '-' }}</p>
        <p class="mb-0"><strong>Tipe Penilaian:</strong> {{ strtoupper($tipe) }}</p>
    </div>

    <div class="card p-4">

        {{-- TAMPILKAN HASIL SESUAI TIPE --}}
        @include("admin.form-asesmen.hasil.hasil-$tipe")

    </div>

</div>

@endsection