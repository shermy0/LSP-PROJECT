@extends('master')

@section('title', 'Permohonan Belum Diisi')

@section('konten')
<div class="container mt-4">
    <div class="alert alert-warning">
        <h4 class="alert-heading">Informasi</h4>
        <p>Asesi <strong>{{ $asesi->nama_lengkap }}</strong> (NIK: {{ $asesi->nik }}) 
        belum mengisi Form Permohonan Sertifikasi (FR.APL.02).</p>
        <hr>
        <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali ke Daftar Asesi</a>
    </div>
</div>
@endsection
