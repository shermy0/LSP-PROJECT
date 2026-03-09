@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h5 class="fw-bold mb-1" style="color:#041562;">
                    <i class="bi bi-clipboard2-check me-2"></i>Evaluasi Penerapan Standar Operasional
                </h5>
                <h6 class="fw-semibold text-muted mb-2">{{ $skema->nama_skema }}</h6>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-1">
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-collection me-1"></i>{{ $pembuatan->judul ?? 'Set #'.$pembuatan->id_pembuatan_pertanyaan }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-briefcase me-1"></i>{{ $kelompok->nama_kelompok ?? '—' }}
                    </span>
                    <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                        <i class="bi bi-clock me-1"></i>{{ $pembuatan->timer ?? 30 }} menit
                    </span>
                </div>
            </div>

            <hr class="mb-0">
        </div>
    </div>

    {{-- Form Jawaban --}}
    <form action="{{ route('jawaban.pmo.simpan', [$skema->id_skema, $pembuatan->id_pembuatan_pertanyaan]) }}" method="POST">
        @csrf

        @forelse($pertanyaan as $i => $p)
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body p-4">
                <div class="d-flex gap-3">
                    {{-- Nomor --}}
                    <span class="fw-bold text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                          style="width:32px; height:32px; background-color:#041562; font-size:0.85rem;">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-grow-1">
                        {{-- Pertanyaan --}}
                        <p class="fw-semibold mb-2" style="color:#041562; font-size:0.95rem;">
                            {{ $p->pertanyaan }}
                        </p>

                        {{-- Unit Kompetensi --}}
                        @php
                            $unitIds = json_decode($p->id_unit, true) ?? [];
                            $units   = $unitList->whereIn('id_unit', $unitIds);
                        @endphp
                        @if($units->count())
                        <div class="mb-3 p-2 rounded-2" style="background-color:#f4f6fb; border-left:3px solid #041562;">
                            <p class="text-muted small fw-semibold mb-1">Unit Kompetensi:</p>
                            @foreach($units as $unit)
                                <div class="d-flex align-items-start gap-2 mb-1">
                                    <i class="bi bi-check-circle-fill mt-1 flex-shrink-0" style="color:#041562; font-size:0.75rem;"></i>
                                    <span style="font-size:0.82rem; color:#333;">{{ $unit->judul_unit }}</span>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Textarea Jawaban --}}
                        <div>
                            <label class="form-label small fw-semibold text-muted mb-1">Tanggapan / Jawaban:</label>
                            <textarea name="jawaban[{{ $p->id_pmo_pertanyaan }}]"
                                      class="form-control rounded-3"
                                      rows="3"
                                      placeholder="Tuliskan tanggapan atau jawaban..."
                                      style="border-color:#d0d7e8; font-size:0.9rem;">{{ old('jawaban.'.$p->id_pmo_pertanyaan, $p->tanggapan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                Belum ada pertanyaan untuk kelompok ini.
            </div>
        </div>
        @endforelse

        {{-- Spacer buat fixed button --}}
        <div style="height:80px;"></div>
    </form>

    {{-- Fixed buttons --}}
    <a href="{{ route('pmo.hasil.kelompok', ['id_skema' => $skema->id_skema]) }}"
       style="position:fixed; bottom:20px; left:260px; z-index:9999;
              background-color:#6c757d; color:#fff; border:none;
              border-radius:50px; padding:10px 18px;
              font-weight:600; font-size:0.85rem;
              box-shadow:0 4px 12px rgba(0,0,0,0.2);
              display:flex; align-items:center; gap:6px;
              text-decoration:none; transition:opacity 0.2s;"
       onmouseover="this.style.opacity='0.85'"
       onmouseout="this.style.opacity='1'">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    @if($pertanyaan->count())
    <button form="form-jawaban" type="submit"
            onclick="submitForm()"
            style="position:fixed; bottom:20px; right:20px; z-index:9999;
                   background-color:#041562; color:#fff; border:none;
                   border-radius:50px; padding:10px 22px;
                   font-weight:600; font-size:0.85rem;
                   box-shadow:0 4px 12px rgba(0,0,0,0.2);
                   display:flex; align-items:center; gap:6px;
                   cursor:pointer; transition:opacity 0.2s;"
            onmouseover="this.style.opacity='0.85'"
            onmouseout="this.style.opacity='1'">
        <i class="bi bi-save"></i> Simpan Jawaban
    </button>
    @endif

</div>

<script>
function submitForm() {
    document.querySelector('form').submit();
}
</script>

@endsection