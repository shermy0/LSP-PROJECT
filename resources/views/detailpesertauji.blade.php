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

    <div class="mt-3 d-flex flex-wrap gap-2">
        <a href="{{ route('datapesertauji') }}" class="btn btn-secondary">Kembali</a>

        {{-- Pastikan user login punya relasi asesor dan relasi skema --}}
        @if(auth()->check() && auth()->user()->asesor && auth()->user()->asesor->skema)
            @foreach(auth()->user()->asesor->skema as $skema)
                <a href="{{ url('/ceklisobservasi') }}?id_skema={{ $skema->id_skema }}&id_asesi={{ $peserta->id_asesi }}"
                   class="btn btn-primary">
                    Isi Ceklis Observasi ({{ $skema->nama_skema }})
                </a>
            @endforeach
        @else
            <p class="text-danger mt-3">Tidak ada skema yang terdaftar untuk asesor ini.</p>
        @endif
    </div>
</div>
@endsection
