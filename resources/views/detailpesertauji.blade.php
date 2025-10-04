@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">Detail Peserta Uji</h4>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <p><strong>Nama Lengkap:</strong> {{ $peserta->nama_lengkap }}</p>
            <p><strong>Kelas:</strong> {{ $peserta->kelas }}</p>

            {{-- Jika ada relasi dengan asesor --}}
            @if($peserta->asesor)
                <p><strong>Asesor:</strong> {{ $peserta->asesor->nama_asesor }}</p>
            @else
                <p><strong>Asesor:</strong> Belum Ditentukan</p>
            @endif
        </div>
    </div>

    <a href="{{ route('datapesertauji') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
