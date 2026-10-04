@extends('master')

@section('konten')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">Kelompok Pekerjaan & Unit Kompetensi</h4>
        <p class="text-muted">
            Skema: <span class="fw-bold">{{ $skema->nama_skema }}</span> |
            Timer: <span class="fw-bold">{{ $timer ?? '—' }} menit</span>
            @if(isset($pembuatan) && $pembuatan)
                | <span class="text-success fw-bold">ID Pembuatan: #{{ $pembuatan->id_pembuatan_pertanyaan }}</span>
            @elseif(isset($id_pembuatan) && $id_pembuatan)
                | <span class="text-success fw-bold">ID Pembuatan: #{{ $id_pembuatan }}</span>
            @endif
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Unit kompetensi belum tersedia',
                    text: @json(session('error')),
                    confirmButtonText: 'Mengerti'
                });
            });
        </script>
    @endif

    @forelse($kelompok as $index => $k)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header" style="background-color:#041562; color:white; font-weight:bold;">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Kelompok {{ $index+1 }}: {{ $k->nama_kelompok }}</span>
                    @if(isset($pembuatan) && $pembuatan || isset($id_pembuatan) && $id_pembuatan)
                            <button
                        class="btn btn-light btn-sm"
                        onclick="popupJumlahPertanyaan(
                            {{ $skema->id_skema }},
                            '{{ $timer ?? 30 }}',
                            {{ $k->id_kelompok }},
                            '{{ addslashes($k->nama_kelompok) }}',
                            {{ $k->unitKompetensi->isNotEmpty() ? 'true' : 'false' }}
                        )">
                        <i class="bi bi-plus-circle"></i> Tambahkan Pertanyaan Lisan
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead style="background-color:#e6eef6; color:#041562; font-weight:bold;">
                            <tr>
                                <th class="text-center" style="width:60px;">No</th>
                                <th style="width:140px;">Kode Unit</th>
                                <th>Judul Unit</th>
                                <th style="width:200px;">Standar Kompetensi</th>
                                <th>Deskripsi Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($k->unitKompetensi as $uIndex => $unit)
                                <tr>
                                    <td class="text-center fw-bold text-dark">{{ $uIndex+1 }}</td>
                                    <td class="fw-bold text-primary">{{ $unit->kode_unit }}</td>
                                    <td>{{ $unit->judul_unit }}</td>
                                    <td>{{ $unit->standar_kompetensi ?? '-' }}</td>
                                    <td>{{ $unit->deskripsi_unit ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">
                                        Belum ada unit kompetensi untuk kelompok ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Daftar soal lisan yang sudah diinput --}}
                @if(isset($soalList) && $soalList->where('id_kelompok', $k->id_kelompok)->count())
                    @php $soalKelompok = $soalList->where('id_kelompok', $k->id_kelompok); @endphp
                    <div class="px-4 py-3" style="border-top: 2px solid #e6eef6;">
                        <p class="fw-bold mb-3" style="font-size:0.8rem; color:#041562; letter-spacing:0.5px;">
                            <i class="bi bi-list-check me-1"></i>SOAL TERSIMPAN ({{ $soalKelompok->count() }})
                        </p>
                        @foreach($soalKelompok as $si => $soal)
                        <div class="card mb-3 border-0 shadow-sm rounded-3">
                            <div class="card-body p-3">
                                <div class="d-flex gap-2">
                                    <span class="fw-bold text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                          style="width:28px;height:28px;background-color:#041562;font-size:0.8rem;">
                                        {{ $si + 1 }}
                                    </span>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1" style="color:#041562; font-size:0.95rem;">
                                            {{ $soal->isi_pertanyaan }}
                                        </p>
                                        @if($soal->kunci_jawaban)
                                            <p class="text-muted small mb-0">
                                                <span class="fw-semibold">Kunci Jawaban:</span> {{ $soal->kunci_jawaban }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    @empty
        <div class="alert alert-warning text-center">Belum ada kelompok pekerjaan untuk skema ini.</div>
    @endforelse
</div>

<script>
@php
    $resolvedIdPembuatan = '';
    if (isset($pembuatan) && $pembuatan) {
        $resolvedIdPembuatan = $pembuatan->id_pembuatan_pertanyaan;
    } elseif (isset($id_pembuatan) && $id_pembuatan) {
        $resolvedIdPembuatan = $id_pembuatan;
    }
@endphp

const globalIdPembuatan = "{{ $resolvedIdPembuatan }}";
const globalJudul       = "{{ addslashes($judul ?? ($pembuatan->judul ?? '')) }}";
const globalTimer       = "{{ $timer ?? 30 }}";

function popupJumlahPertanyaan(id_skema, timer, kelompok_id, nama_kelompok, hasUnits) {
    if (!hasUnits) {
        Swal.fire({
            icon: 'warning',
            title: 'Unit kompetensi belum tersedia',
            text: 'Tambahkan unit kompetensi terlebih dahulu sebelum membuat pertanyaan lisan.',
            confirmButtonText: 'Mengerti'
        });
        return;
    }

    Swal.fire({
        title: `Jumlah Pertanyaan - ${nama_kelompok}`,
        html: `
            <input id="jumlahPertanyaan" type="number" class="form-control mb-2 text-center border-primary"
                   min="1" max="15" value="1">
            <small class="text-danger d-block mb-3">Maksimal 15 pertanyaan</small>
        `,
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-4 shadow-lg p-4',
            confirmButton: 'swal2-confirm btn fw-bold px-4 me-2',
            cancelButton: 'swal2-cancel btn fw-bold px-4'
        },
        didRender: () => {
            document.querySelector('.swal2-confirm').style.cssText = 'background:#041562; color:#fff; border-radius:8px;';
            document.querySelector('.swal2-cancel').style.cssText  = 'background:#6c757d; color:#fff; border-radius:8px;';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let jumlah = parseInt(document.getElementById('jumlahPertanyaan').value);
            if (isNaN(jumlah) || jumlah < 1) jumlah = 1;
            if (jumlah > 15) jumlah = 15;

            let url = `{{ url('/lisan/input') }}/${id_skema}`
                    + `?timer=${timer}`
                    + `&kelompok_id=${kelompok_id}`
                    + `&jumlah=${jumlah}`
                    + `&id_pembuatan=${globalIdPembuatan}`
                    + `&judul=${encodeURIComponent(globalJudul)}`;

            window.location.href = url;
        }
    });
}
</script>

{{-- Kembali (kiri bawah) --}}
<a href="{{ route('pertanyaan.lisan', ['id_skema' => $skema->id_skema]) }}"
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

{{-- TTD Asesmen (kanan bawah) --}}
@if($resolvedIdPembuatan)
<a href="{{ route('tanda.tangan.asesmen', [$skema->id_skema, $resolvedIdPembuatan]) }}"
   style="position:fixed; bottom:20px; right:20px; z-index:9999;
          background-color:#041562; color:#fff; border:none;
          border-radius:50px; padding:10px 18px;
          font-weight:600; font-size:0.85rem;
          box-shadow:0 4px 12px rgba(0,0,0,0.2);
          display:flex; align-items:center; gap:6px;
          text-decoration:none; transition:opacity 0.2s;"
   onmouseover="this.style.opacity='0.85'"
   onmouseout="this.style.opacity='1'">
    <i class="bi bi-pen-fill"></i> TTD Asesmen
</a>
@endif

@endsection
