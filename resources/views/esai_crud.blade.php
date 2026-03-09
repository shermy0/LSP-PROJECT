@extends('master')

@section('konten')
<div class="container mt-4">

    {{-- ===== BACK BUTTON ===== --}}
    <div class="mb-3">
        <a href="{{ route('pertanyaan.esai.kelompok', [
                'id_skema' => $id_skema,
                'jenis'    => 'esai',
                'id_pembuatan_pertanyaan' => $pembuatan_pertanyaan->id_pembuatan_pertanyaan ?? '',
            ]) }}"
            class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <h4 class="fw-bold">FR.IA.07 – DPL – Daftar Pertanyaan Esai</h4>

    {{-- Info pembuatan --}}
    @if($pembuatan_pertanyaan)
        <p class="text-muted mb-3">
            ID Pembuatan: <span class="fw-bold">{{ $pembuatan_pertanyaan->id_pembuatan_pertanyaan }}</span> |
            Judul: <span class="fw-bold">{{ $pembuatan_pertanyaan->judul ?? '-' }}</span> |
            Timer: <span class="fw-bold">{{ $pembuatan_pertanyaan->timer }} menit</span>
        </p>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter pertanyaan berdasarkan id_pembuatan_pertanyaan saja --}}
    @php
        $filtered = $pertanyaan->filter(function($p) use ($pembuatan_pertanyaan) {
            return !$pembuatan_pertanyaan 
                || $p->id_pembuatan_pertanyaan == $pembuatan_pertanyaan->id_pembuatan_pertanyaan;
        });
    @endphp

    @if($filtered->isEmpty())
        <div class="alert alert-warning">Belum ada pertanyaan esai untuk pembuatan ini.</div>
    @else
        @foreach($filtered as $index => $p)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $loop->iteration }}. Pertanyaan Esai:</h6>
                    <p>{{ $p->isi_pertanyaan }}</p>

                    @if($p->kunci_jawaban)
                        <p class="mb-1"><strong>Kunci Jawaban:</strong> {{ $p->kunci_jawaban }}</p>
                    @endif

                    @if($p->file_path)
                        <p><strong>Lampiran:</strong>
                            <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat File</a>
                        </p>
                    @endif

                    {{-- Tombol Edit & Hapus --}}
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('pertanyaan.esai.edit', $p->id_pertanyaan) }}"
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('pertanyaan.esai.delete', $p->id_pertanyaan) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection