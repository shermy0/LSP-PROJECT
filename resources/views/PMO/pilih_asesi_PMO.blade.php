@extends('master')
@section('konten')
<div class="container mt-4">

    {{-- Header --}}
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="color:#041562;">Pilih Asesi</h4>
        <p class="text-muted mb-0">{{ $skema->nama_skema }}</p>
        <small class="text-muted">
            Set: <strong>{{ $pembuatan->judul ?? 'Set #'.$pembuatan->id_pembuatan_pertanyaan }}</strong>
            &nbsp;|&nbsp; Kelompok: <strong>{{ $kelompok->nama_kelompok ?? '—' }}</strong>
        </small>
    </div>

    {{-- Search --}}
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text" style="background-color:#041562; border-color:#041562;">
                <i class="bi bi-search text-white"></i>
            </span>
            <input type="text" id="searchAsesi" class="form-control"
                   placeholder="Cari nama asesi..."
                   oninput="filterAsesi()">
        </div>
    </div>

    {{-- List Asesi --}}
    <div class="row g-3" id="asesiList">
        @forelse($asesiList as $asesi)
            @php $sudah = in_array($asesi->id_asesi, $sudahInputIds); @endphp
            <div class="col-md-6 col-lg-4 asesi-item"
                 data-nama="{{ strtolower($asesi->nama_lengkap) }}">
                <div class="card border-0 shadow-sm rounded-4 h-100 asesi-card"
                     data-id="{{ $asesi->id_asesi }}"
                     data-nama-asesi="{{ addslashes($asesi->nama_lengkap) }}"
                     data-sudah="{{ $sudah ? '1' : '0' }}"
                     style="transition:all 0.2s; border:2px solid transparent !important;
                            cursor: {{ $sudah ? 'not-allowed' : 'pointer' }};
                            {{ $sudah ? 'background-color:#f8fff9;' : '' }}">
                    <div class="card-body px-4 py-3 d-flex align-items-center gap-3">
                        {{-- Avatar --}}
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-white"
                             style="width:44px; height:44px; font-size:1rem;
                                    background-color:{{ $sudah ? '#28a745' : '#041562' }};">
                            {{ strtoupper(substr($asesi->nama_lengkap, 0, 1)) }}
                        </div>

                        {{-- Info --}}
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="fw-bold mb-0 text-truncate"
                               style="color:{{ $sudah ? '#28a745' : '#041562' }}; font-size:0.9rem;">
                                {{ $asesi->nama_lengkap }}
                            </p>
                            @if($sudah)
                                <small class="text-success fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i>Sudah diinput
                                </small>
                            @elseif(isset($asesi->telepon_hp) && $asesi->telepon_hp)
                                <small class="text-muted">
                                    <i class="bi bi-telephone me-1"></i>{{ $asesi->telepon_hp }}
                                </small>
                            @else
                                <small class="text-muted">No telepon tidak tersedia</small>
                            @endif
                        </div>

                        {{-- Icon kanan --}}
                        @if($sudah)
                            <i class="bi bi-check-circle-fill flex-shrink-0" style="color:#28a745; font-size:1.1rem;"></i>
                        @else
                            <i class="bi bi-arrow-right flex-shrink-0" style="color:#041562;"></i>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-people fs-2 d-block mb-2"></i>
                        Belum ada asesi terdaftar.
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Empty state search --}}
    <div id="emptySearch" class="text-center text-muted py-4" style="display:none;">
        <i class="bi bi-search fs-3 d-block mb-2"></i>
        Asesi tidak ditemukan.
    </div>

    <div style="height:80px;"></div>
</div>

{{-- Kembali --}}
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

<script>
const idSkema     = {{ $skema->id_skema }};
const idPembuatan = {{ $pembuatan->id_pembuatan_pertanyaan }};
const idKelompok  = {{ $kelompok->id_kelompok ?? 0 }};

// Event listener untuk semua card asesi
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.asesi-card').forEach(function (card) {
        const sudah   = card.dataset.sudah === '1';
        const idAsesi = card.dataset.id;
        const nama    = card.dataset.namaAsesi;

        if (sudah) {
            card.style.cursor = 'not-allowed';
            card.addEventListener('click', function () {
                Swal.fire({
                    title: 'Sudah Diinput',
                    html: `Jawaban untuk <strong>${nama}</strong> sudah pernah diinput.`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#041562'
                });
            });
        } else {
            // Belum diinput — bisa diklik
            card.style.cursor = 'pointer';

            card.addEventListener('mouseenter', function () {
                card.style.setProperty('border-color', '#041562', 'important');
                card.style.backgroundColor = '#f0f4ff';
            });
            card.addEventListener('mouseleave', function () {
                card.style.setProperty('border-color', 'transparent', 'important');
                card.style.backgroundColor = '';
            });
            card.addEventListener('click', function () {
                pilihAsesi(idAsesi, nama);
            });
        }
    });
});

function pilihAsesi(idAsesi, namaAsesi) {
    Swal.fire({
        title: 'Konfirmasi',
        html: `Lanjutkan input jawaban untuk <strong>${namaAsesi}</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn fw-bold px-4 me-2 text-white',
            cancelButton: 'btn btn-secondary fw-bold px-4'
        },
        didRender: () => {
            document.querySelector('.swal2-confirm').style.backgroundColor = '#041562';
        }
    }).then(result => {
        if (result.isConfirmed) {
            window.location.href = `{{ url('/pmo/hasil') }}/${idSkema}/${idPembuatan}/${idKelompok}/${idAsesi}`;
        }
    });
}

function filterAsesi() {
    const keyword = document.getElementById('searchAsesi').value.toLowerCase();
    const items   = document.querySelectorAll('.asesi-item');
    let visible   = 0;

    items.forEach(item => {
        const nama = item.dataset.nama || '';
        if (nama.includes(keyword)) {
            item.style.display = '';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('emptySearch').style.display = visible === 0 ? 'block' : 'none';
}
</script>

@endsection