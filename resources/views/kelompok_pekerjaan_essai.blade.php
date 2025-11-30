@extends('master')

@section('konten')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">Kelompok Pekerjaan & Unit Kompetensi</h4>
        <p class="text-muted">
            Skema ID: <span class="fw-bold">{{ $id_skema }}</span> | 
            Timer: <span class="fw-bold">{{ $timer }} menit</span>
        </p>
    </div>

    @forelse($kelompok as $index => $k)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header" style="background-color:#041562; color:white; font-weight:bold;">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Kelompok {{ $index+1 }}: {{ $k->nama_kelompok }}</span>
                    <button 
                        class="btn btn-light btn-sm"
                        onclick="popupJumlahPertanyaan({{ $id_skema }}, '{{ $timer }}', {{ $k->id_kelompok }})">
                        <i class="bi bi-plus-circle"></i> Tambahkan Pertanyaan
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead style="background-color:#e6eef6; color:#041562; font-weight:bold;">
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
function popupJumlahPertanyaan(id_skema, timer, kelompok_id) {
    Swal.fire({
        title: '<h6 class="fw-bold mb-3">Masukkan Jumlah Pertanyaan</h6>',
        html: `
            <input id="jumlahPertanyaan" type="number" class="form-control mb-2 text-center border-primary" 
                   style="border:2px solid #041562; border-radius:8px;" 
                   min="1" max="15" value="1">
            <small class="text-danger d-block mb-3">note: maksimal 15 pertanyaan</small>
        `,
        showCancelButton: true,
        confirmButtonText: 'Lanjutkan',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            let jumlah = parseInt(document.getElementById('jumlahPertanyaan').value);
            if (isNaN(jumlah) || jumlah < 1 || jumlah > 15) {
                Swal.fire('Error', 'Jumlah pertanyaan harus antara 1–15', 'error');
                return;
            }

            // ✅ id_pembuatan_pertanyaan benar-benar dikirim
            let url = `{{ route('pertanyaan.esai.create') }}?id_skema=${id_skema}&timer=${timer}&kelompok_id=${kelompok_id}&jumlah=${jumlah}&id_pembuatan_pertanyaan={{ $pembuatan->id_pembuatan_pertanyaan ?? '' }}`;
            window.location.href = url;
        }
    });
}
</script>
@endsection
