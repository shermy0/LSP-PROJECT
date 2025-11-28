@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

    <div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
<li class="breadcrumb-item">
    @isset($skema)
        <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
    @else
        <span>Form Perencanaan</span>
    @endisset
</li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.01</li>
        </ol>
    </nav>
    <div class="container mt-4">

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.05 – LAPORAN ASESMEN</h3>
    </div>

    <!-- skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>
    
        <!-- TUK -->
    <div class="col-12 mb-3">
                    <div class="mapa-box">
        <label class="form-label fw-semibold text-center d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
        <div class="d-flex justify-content-center gap-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu" disabled>
                <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja" disabled>
                <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri" checked>
                <label class="form-check-label" for="tukMandiri">Mandiri</label>
            </div>
        </div>
    </div>
    </div>

    <div class="row g-3">
        
        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                <div class="jenis-skema">
                    <input type="radio" id="kkni" name="skema" class="form-check-input me-2"
                        value="KKNI"
                        @if($skema->jenjang == 'KKNI') checked @endif disabled>
                    <label for="kkni">KKNI</label>

                    <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                        value="Okupasi"
                        @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                    <label for="okupasi">Okupasi</label>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
            </div>
        </div>

        <!-- Nama Asesor -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label for="namaAsesor" class="form-label">Nama Asesor</label>
                <select class="form-control" id="namaAsesor" name="asesor_id">
                    <option value="">-- Pilih Asesor --</option>
                    @foreach($asesors as $asesor)
                        <option value="{{ $asesor->id_asesor }}"
                            data-no="{{ $asesor->no_registrasi }}"
                            @if(session('asesor_terpilih') == $asesor->id_asesor) selected @endif>
                            {{ $asesor->nama_asesor }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tanggal Asesmen -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen">
            </div>
        </div>
    </div>


    </div>
    </div>
</div>

<form id="simpan-lanjut-form" action="{{ route('laporan.store', $skema->id_skema) }}" method="POST" class="simpan-form mt-4">
    @csrf

<!-- Data Asesi -->
    <div class="card mapa-card">
    <div class="judul-box">
        <div class="judul-header">Data Asesi</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table text-center align-middle">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">No</th>
                        <th rowspan="2" class="text-center align-middle">Nama Asesi</th>
                        <th colspan="2" class="text-center">Rekomendasi</th>
                        <th rowspan="2" class="text-center align-middle">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center">K</th>
                        <th class="text-center">BK</th>
                    </tr>
                </thead>
                <tbody id="asesiTableBody">
                    <tr>
                        <td colspan="5">Silakan pilih asesor terlebih dahulu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Catatan Asesmen -->
    <!-- hidden input supaya data ikut terkirim -->
    <input type="hidden" name="asesor_id" id="asesor_id_hidden">
    <input type="hidden" name="skema_id" id="skema_id_hidden" value="{{ $skema->id_skema }}">
    <input type="hidden" name="no_registrasi" id="no_registrasi_hidden">

    <div class="card mapa-card">
        <div class="judul-box">
            <div class="judul-header">Catatan Asesmen</div>

            <div class="box">
                <div class="box-header">Aspek Negatif dan Positif dalam Asesmen</div>
                <textarea name="aspek_positif_negatif" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>

            <div class="box">
                <div class="box-header">Pencatatan Penolakan Hasil Asesmen</div>
                <textarea name="penolakan" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>

            <div class="box">
                <div class="box-header">Saran Perbaikan : (Asesor/Personil Terkait)</div>
                <textarea name="saran_perbaikan" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
            </div>
        </div>
    </div>
    </div>

    <button type="submit" class="simpan-btn mt-3">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const asesorSelect = document.getElementById('nama_asesor');
    const tanggalInput = document.getElementById('tanggalAsesmen');
    
    // Validasi sebelum submit - SAMA SEPERTI DI LAPORAN
    form.addEventListener('submit', function(e) {
        const asesorValue = asesorSelect.value;
        const tanggalValue = tanggalInput.value;
        
        // Cek apakah asesor belum dipilih
        if (!asesorValue || asesorValue === '') {
            e.preventDefault(); // Cegah submit HANYA kalau validasi gagal
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Silakan pilih Nama Asesor terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        // Cek apakah tanggal belum diisi
        if (!tanggalValue || tanggalValue === '') {
            e.preventDefault(); // Cegah submit HANYA kalau validasi gagal
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Silakan isi Tanggal Asesmen terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        // Jika lolos validasi, biarkan form submit secara normal (tidak perlu form.submit() manual)
    });
});
</script>
@endsection