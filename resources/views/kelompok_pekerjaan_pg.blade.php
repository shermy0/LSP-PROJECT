@extends('master')

@section('konten')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">Kelompok Pekerjaan & Unit Kompetensi - Pilihan Ganda</h4>
        <p class="text-muted">
            Skema: <span class="fw-bold">{{ $skema->nama_skema ?? 'N/A' }}</span> | 
            Timer: <span class="fw-bold">{{ $timer }} menit</span> |
            Jenis: <span class="fw-bold text-primary">Pilihan Ganda</span>
        </p>
    </div>

    @forelse($kelompok as $index => $k)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header" style="background-color:#0d6efd; color:white; font-weight:bold;">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Kelompok {{ $index+1 }}: {{ $k->nama_kelompok }}</span>
                    <button class="btn btn-light btn-sm"
                            onclick="popupJumlahPertanyaan(
                                {{ $id_skema }}, 
                                '{{ $timer }}', 
                                {{ $k->id_kelompok }},
                                '{{ $id_pembuatan_pertanyaan ?? '' }}'
                            )">
                        <i class="bi bi-plus-circle"></i> Tambahkan Pertanyaan
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead style="background-color:#e6f2ff; color:#0d6efd; font-weight:bold;">
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th style="width: 140px;">Kode Unit</th>
                                <th>Judul Unit</th>
                                <th style="width: 200px;">Standar Kompetensi</th>
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
        <div class="alert alert-warning text-center">
            Belum ada kelompok pekerjaan untuk skema ini.
        </div>
    @endforelse
</div>

<script>
function popupJumlahPertanyaan(id_skema, timer, id_kelompok, id_pembuatan_pertanyaan = '') {
    Swal.fire({
        title: '<h6 class="fw-bold mb-3">Masukkan Jumlah Pertanyaan Pilihan Ganda</h6>',
        html: `
            <input id="jumlahPertanyaanPG" type="number" class="form-control mb-2 text-center border-primary" 
                   style="border:2px solid #0d6efd; border-radius:8px;" 
                   min="1" max="20" value="5">
            <small class="text-danger d-block mb-3">note: maksimal 20 pertanyaan</small>
            <small class="text-info d-block mb-2">Setiap pertanyaan akan memiliki 5 opsi (A, B, C, D, E)</small>
            <div class="mt-3 p-2 border rounded bg-light">
                <small class="text-dark fw-bold">Timer: ${timer} menit</small>
            </div>
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
            const confirmBtn = document.querySelector('.swal2-confirm');
            confirmBtn.style.backgroundColor = '#0d6efd';
            confirmBtn.style.color = '#fff';
            confirmBtn.style.borderRadius = '8px';

            const cancelBtn = document.querySelector('.swal2-cancel');
            cancelBtn.style.backgroundColor = '#6c757d';
            cancelBtn.style.color = '#fff';
            cancelBtn.style.borderRadius = '8px';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let jumlah = parseInt(document.getElementById('jumlahPertanyaanPG').value);
            if (isNaN(jumlah) || jumlah < 1) {
                Swal.fire('Error', 'Minimal 1 pertanyaan', 'error');
                return;
            }
            if (jumlah > 20) {
                Swal.fire('Error', 'Maksimal 20 pertanyaan', 'error');
                return;
            }

            // Build URL dengan parameter yang sesuai
            let url = `{{ route('pertanyaan.pg.create') }}?id_skema=${id_skema}&timer=${timer}&id_kelompok=${id_kelompok}&jumlah=${jumlah}`;
            
            // Tambahkan id_pembuatan_pertanyaan jika ada (mode Lanjutkan)
            if (id_pembuatan_pertanyaan) {
                url += `&id_pembuatan_pertanyaan=${id_pembuatan_pertanyaan}`;
            }

            window.location.href = url;
        }
    });
}
</script>
@endsection