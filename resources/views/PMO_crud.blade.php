@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="p-3 mb-4 rounded shadow-sm" style="background-color:#041562; color:white;">
        <h4 class="fw-bold mb-0">
            FR.PMO – Daftar Pertanyaan PMO
            <span class="fw-normal" style="font-size:0.9rem;">
                (PMO: {{ $pmo->nama_pmo ?? 'Tanpa Nama' }})
            </span>
        </h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php $currentKelompok = null; $nomorPerKelompok = 0; @endphp

    @forelse($pertanyaanList as $p)
    @php
        $unitIds = json_decode($p->id_unit, true) ?? [$p->id_unit];
        $units   = $unitList->whereIn('id_unit', $unitIds);
    @endphp

    {{-- ✅ Tampilkan header kelompok kalau berganti --}}
    @if($currentKelompok !== $p->id_kelompok)
        @php $currentKelompok = $p->id_kelompok; $nomorPerKelompok = 0; @endphp
        <div class="d-flex align-items-center mb-3 mt-4">
            <div class="flex-grow-1 border-top" style="border-color:#041562!important;"></div>
            <span class="mx-3 fw-bold px-3 py-1 rounded-pill text-white"
                  style="background-color:#041562; font-size:0.9rem;">
                📁 {{ $p->nama_kelompok ?? 'Tanpa Kelompok' }}
            </span>
            <div class="flex-grow-1 border-top" style="border-color:#041562!important;"></div>
        </div>
    @endif
    @php $nomorPerKelompok++; @endphp

    <div class="card mb-3 border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="row g-0">

                {{-- Nomor --}}
                <div class="col-auto me-3">
                    <span class="fw-bold text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width:32px;height:32px;background-color:#041562;font-size:0.85rem;">
                        {{ $nomorPerKelompok }}
                    </span>
                </div>

                {{-- Konten --}}
                <div class="col">

                    {{-- Pertanyaan --}}
                    <p class="fw-semibold mb-2" style="color:#041562; font-size:1rem;">
                        {{ $p->pertanyaan }}
                    </p>

                    {{-- Deskripsi --}}
                    @if($p->deskripsi_pertanyaan)
                        <p class="text-muted small mb-2">
                            <i class="bi bi-info-circle me-1"></i>{{ $p->deskripsi_pertanyaan }}
                        </p>
                    @endif

                    {{-- Unit Kompetensi --}}
                    <div class="p-2 rounded-2 mb-3" style="background-color:#f4f6fb; border-left: 3px solid #041562;">
                        <p class="text-muted small fw-semibold mb-1">Unit Kompetensi:</p>
                        @foreach($units as $unit)
                            <div class="d-flex align-items-start gap-2 mb-1">
                                <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" style="color:#041562; font-size:0.75rem;"></i>
                                <span style="font-size:0.85rem; color:#333;">{{ $unit->judul_unit }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('pmo.pertanyaan.edit', [$pmo->id_pmo, $p->id_pmo_pertanyaan]) }}"
                           class="btn btn-sm btn-warning px-3">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('pmo.pertanyaan.destroy', [$pmo->id_pmo, $p->id_pmo_pertanyaan]) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin mau hapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            Belum ada pertanyaan pada PMO ini.
        </div>
    @endforelse

</div>

<div style="position: fixed; bottom: 20px; right: 20px; z-index: 999; display: flex; gap: 10px;">

    @if($id_pembuatan)
        <a href="{{ route('tanda.tangan.asesmen', [$pmo->id_skema, $id_pembuatan]) }}"
           class="btn btn-primary fw-bold">
            <i class="bi bi-pen-fill me-1"></i> TTD Asesmen
        </a>
    @endif

    <a href="{{ route('pertanyaan.pmo.kelompok', ['id_skema' => $pmo->id_skema]) }}"
       class="btn btn-secondary fw-bold">
        &laquo; Kembali
    </a>

</div>
@endsection