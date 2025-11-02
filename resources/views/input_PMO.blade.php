@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-dark mb-3">Input Pertanyaan PMO</h4>

    <form action="{{ route('pmo.pertanyaan.pmo.store', ['id_pmo' => $id_pmo]) }}" method="POST">
        @csrf

        <!-- Pilih Unit Kompetensi -->
        <div class="mb-3">
            <label class="form-label fw-bold">
                Pilih Unit Kompetensi (kategori)
                <small class="text-muted">(bisa pilih lebih dari 1)</small>
            </label>

            @forelse($kelompok as $k)
                @if($k->unitKompetensi->count() > 0)
                    <div class="mb-3">
                        <strong>{{ $k->nama_kelompok }}</strong>
                        <div class="ms-3 mt-2">
                            @foreach ($k->unitKompetensi as $unit)
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="id_unit[]" 
                                        value="{{ $unit->id_unit }}" 
                                        id="unit_{{ $unit->id_unit }}">
                                    <label class="form-check-label" for="unit_{{ $unit->id_unit }}">
                                        {{ $unit->kode_unit }} – {{ $unit->judul_unit }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mb-2 text-danger">
                        Kelompok {{ $k->nama_kelompok }} belum memiliki unit kompetensi.
                    </div>
                @endif
            @empty
                <div class="text-danger">Belum ada kelompok atau unit kompetensi tersedia.</div>
            @endforelse
        </div>

        <!-- Pertanyaan -->
        <div class="mb-3">
            <label for="pertanyaan" class="form-label fw-bold">Pertanyaan</label>
            <textarea 
                name="pertanyaan" 
                id="pertanyaan" 
                class="form-control" 
                rows="3" 
                placeholder="Tulis pertanyaan di sini..." 
                required></textarea>
        </div>

        <!-- Deskripsi / Kunci Jawaban -->
        <div class="mb-3">
            <label for="deskripsi_pertanyaan" class="form-label fw-bold">Deskripsi / Kunci Jawaban</label>
            <textarea 
                name="deskripsi_pertanyaan" 
                id="deskripsi_pertanyaan" 
                class="form-control" 
                rows="2" 
                placeholder="Tulis deskripsi atau kunci jawaban di sini..."></textarea>
        </div>

        <input type="hidden" name="id_pmo" value="{{ $id_pmo }}">

        <div class="text-end mt-4">
            <button type="submit" class="btn text-white px-4 py-2" style="background-color: #041562;">
                Simpan Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection
