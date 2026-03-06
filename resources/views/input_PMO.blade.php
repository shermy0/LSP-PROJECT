@extends('master')
@section('konten')
<div class="container mt-4">

    <h4 class="fw-bold text-dark mb-1">Input Pertanyaan PMO</h4>
    <p class="text-muted mb-1">
        Kelompok: <strong>{{ $kelompok->nama_kelompok ?? '—' }}</strong>
    </p>
    <p class="text-muted mb-4">
        Jumlah pertanyaan: <strong>{{ $jumlah ?? 1 }}</strong>
        @if($id_pembuatan)
            | ID Pembuatan: <span class="text-success fw-bold">#{{ $id_pembuatan }}</span>
        @endif
    </p>

    <form action="{{ route('pmo.pertanyaan.pmo.store', ['id_pmo' => $id_pmo]) }}" method="POST">
    @csrf
    <input type="hidden" name="id_pmo" value="{{ $id_pmo }}">
    
    {{-- ✅ TAMBAH INI --}}
    <input type="hidden" name="id_kelompok" value="{{ $kelompok->id_kelompok ?? '' }}">

    @if($id_pembuatan)
        <input type="hidden" name="id_pembuatan" value="{{ $id_pembuatan ?? '' }}">
    @endif

        @for($i = 0; $i < ($jumlah ?? 1); $i++)
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header d-flex align-items-center" style="background-color:#041562; color:white;">
                    <span class="rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold"
                          style="width:28px; height:28px; background:#ffffff20; font-size:13px; border:2px solid #fff; flex-shrink:0;">
                        {{ $i + 1 }}
                    </span>
                    <span class="fw-bold">Pertanyaan ke-{{ $i + 1 }}</span>
                </div>
                <div class="card-body">

                    {{-- Unit Kompetensi per pertanyaan — hanya unit dari kelompok ini --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Unit Kompetensi
                            <small class="text-muted fw-normal">(bisa pilih lebih dari 1)</small>
                        </label>
                        @forelse($unitKompetensi as $unit)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox"
                                       name="id_unit[{{ $i }}][]"
                                       value="{{ $unit->id_unit }}"
                                       id="unit_{{ $i }}_{{ $unit->id_unit }}">
                                <label class="form-check-label" for="unit_{{ $i }}_{{ $unit->id_unit }}">
                                    <span class="badge me-1" style="background-color:#e6eef6; color:#041562;">
                                        {{ $unit->kode_unit }}
                                    </span>
                                    {{ $unit->judul_unit }}
                                </label>
                            </div>
                        @empty
                            <div class="text-danger">Belum ada unit kompetensi untuk kelompok ini.</div>
                        @endforelse
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pertanyaan</label>
                        <textarea name="pertanyaan[]" class="form-control" rows="3"
                                  placeholder="Tulis pertanyaan ke-{{ $i + 1 }}..." required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Deskripsi / Kunci Jawaban</label>
                        <textarea name="deskripsi_pertanyaan[]" class="form-control" rows="2"
                                  placeholder="Tulis deskripsi atau kunci jawaban..."></textarea>
                    </div>

                </div>
            </div>
        @endfor

        <div class="d-flex justify-content-between mt-2 mb-5">
            <a href="javascript:history.back()" class="btn btn-secondary px-4">Kembali</a>
            <button type="submit" class="btn text-white px-4" style="background-color:#041562;">
                Simpan Semua Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection