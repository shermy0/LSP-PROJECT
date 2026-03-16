@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="color:#041562;">Jawaban Hasil Ujian Lisan</h4>
        <p class="text-muted mb-0">{{ $skema->nama_skema }}</p>
        <small class="text-muted">Pilih set pertanyaan, lalu pilih kelompok pekerjaan</small>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STEP 1: Pilih Set Pembuatan --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header rounded-top-4 py-3 px-4" style="background-color:#041562;">
            <h6 class="fw-bold text-white mb-0">
                <span class="badge bg-white me-2" style="color:#041562; font-size:0.75rem;">STEP 1</span>
                Pilih Set Pertanyaan Lisan
            </h6>
        </div>
        <div class="card-body p-4">
            @forelse($pembuatanList as $pm)
                <div class="card border-0 shadow-sm rounded-3 mb-3 pembuatan-card"
                     id="pm-{{ $pm->id_pembuatan_pertanyaan }}"
                     onclick="pilihPembuatan({{ $pm->id_pembuatan_pertanyaan }}, '{{ addslashes($pm->judul ?? 'Set #'.$pm->id_pembuatan_pertanyaan) }}', {{ $pm->timer ?? 30 }})"
                     style="cursor:pointer; transition:all 0.2s; border:2px solid transparent !important;">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0" style="color:#041562;">
                                    {{ $pm->judul ?? 'Set Pertanyaan #'.$pm->id_pembuatan_pertanyaan }}
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>{{ $pm->timer ?? 30 }} menit &nbsp;|&nbsp;
                                    <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($pm->timescap)->format('d-m-Y H:i') }}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562;">
                                    ID #{{ $pm->id_pembuatan_pertanyaan }}
                                </span>
                                <i class="bi bi-chevron-right check-icon" style="color:#ccc; font-size:1.1rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                    Belum ada set pertanyaan lisan.
                </div>
            @endforelse
        </div>
    </div>

    {{-- STEP 2: Pilih Kelompok --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4" id="step2-card" style="display:none !important;">
        <div class="card-header rounded-top-4 py-3 px-4" style="background-color:#041562;">
            <h6 class="fw-bold text-white mb-0">
                <span class="badge bg-white me-2" style="color:#041562; font-size:0.75rem;">STEP 2</span>
                Pilih Kelompok Pekerjaan
                <span class="ms-2 fw-normal opacity-75" id="label-pembuatan-terpilih" style="font-size:0.8rem;"></span>
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($kelompok as $k)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-3 h-100"
                             style="cursor:pointer; transition:all 0.2s; border:2px solid transparent !important;"
                             onclick="pergiKeJawaban({{ $k->id_kelompok }})">
                            <div class="card-body px-4 py-3 d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:40px; height:40px; background-color:#e8edf8;">
                                    <i class="bi bi-briefcase" style="color:#041562;"></i>
                                </div>
                                <div>
                                    <p class="fw-bold mb-0" style="color:#041562; font-size:0.9rem;">{{ $k->nama_kelompok }}</p>
                                    <small class="text-muted">{{ $k->unitKompetensi->count() }} unit kompetensi</small>
                                </div>
                                <i class="bi bi-arrow-right ms-auto" style="color:#041562;"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <a href="{{ route('pertanyaan.lisan', $skema->id_skema) }}"
       style="position:fixed; bottom:20px; left:260px; z-index:9999;
              background-color:#041562; color:#fff; border:none;
              border-radius:50px; padding:10px 18px;
              font-weight:600; font-size:0.85rem;
              box-shadow:0 4px 12px rgba(0,0,0,0.2);
              display:flex; align-items:center; gap:6px;
              text-decoration:none; transition:opacity 0.2s;"
       onmouseover="this.style.opacity='0.85'"
       onmouseout="this.style.opacity='1'">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

</div>

<script>
let selectedIdPembuatan = null;

function pilihPembuatan(id, judul, timer) {
    document.querySelectorAll('.pembuatan-card').forEach(el => {
        el.style.borderColor = 'transparent';
        el.style.backgroundColor = '';
        el.querySelector('.check-icon').style.color = '#ccc';
    });
    const card = document.getElementById('pm-' + id);
    card.style.borderColor = '#041562';
    card.style.backgroundColor = '#f0f4ff';
    card.querySelector('.check-icon').style.color = '#041562';
    selectedIdPembuatan = id;
    const step2 = document.getElementById('step2-card');
    step2.style.setProperty('display', 'block', 'important');
    document.getElementById('label-pembuatan-terpilih').textContent = '— ' + judul;
    setTimeout(() => step2.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
}

function pergiKeJawaban(id_kelompok) {
    if (!selectedIdPembuatan) { alert('Pilih set pertanyaan terlebih dahulu.'); return; }
    window.location.href = `{{ url('/lisan/hasil') }}/{{ $skema->id_skema }}/${selectedIdPembuatan}/${id_kelompok}`;
}
</script>

<style>
.pembuatan-card:hover { background-color: #f8f9ff !important; border-color: #041562 !important; }
#step2-card .card:hover { background-color: #f0f4ff !important; border-color: #041562 !important; }
</style>

@endsection