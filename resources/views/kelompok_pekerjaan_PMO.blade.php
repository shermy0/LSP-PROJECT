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

    @forelse($kelompok as $index => $k)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header" style="background-color:#041562; color:white; font-weight:bold;">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Kelompok {{ $index+1 }}: {{ $k->nama_kelompok }}</span>
                    <button
                        class="btn btn-light btn-sm"
                        onclick="popupJumlahPertanyaan(
                            {{ $skema->id_skema }},
                            '{{ $timer ?? 30 }}',
                            {{ $k->id_kelompok }},
                            '{{ addslashes($k->nama_kelompok) }}'
                        )">
                        <i class="bi bi-plus-circle"></i> Tambahkan Pertanyaan PMO
                    </button>
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

    $resolvedIdPmo = '';
    if (isset($id_pmo) && $id_pmo) {
        $resolvedIdPmo = $id_pmo;
    } else {
        $pmoDb = \App\Models\PMO::where('id_skema', $skema->id_skema)->latest('id_pmo')->first();
        if ($pmoDb) $resolvedIdPmo = $pmoDb->id_pmo;
    }
@endphp

const globalIdPembuatan = "{{ $resolvedIdPembuatan }}";
const globalIdPmo       = "{{ $resolvedIdPmo }}";

function popupJumlahPertanyaan(id_skema, timer, kelompok_id, nama_kelompok) {
    Swal.fire({
        title: `Jumlah Pertanyaan – ${nama_kelompok}`,
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

            // ✅ Selalu kirim id_pmo dan id_pembuatan yang sudah ada
            let url = `{{ url('/form-asesmen') }}/${id_skema}/input-pmo`
                    + `?timer=${timer}`
                    + `&kelompok_id=${kelompok_id}`
                    + `&jumlah=${jumlah}`
                    + `&id_pmo=${globalIdPmo}`
                    + `&id_pembuatan=${globalIdPembuatan}`;

            window.location.href = url;
        }
    });
}
</script>
@endsection