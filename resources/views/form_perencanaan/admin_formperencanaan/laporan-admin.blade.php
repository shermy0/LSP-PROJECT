@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .readonly-input,
    .readonly-textarea {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6;
        color: #212529 !important;
    }

    .disabled-checkbox,
    .disabled-radio {
        pointer-events: none;
        opacity: 0.7;
    }

    .floating-download-btn {
        position: fixed;
        bottom: 40px;
        right: 40px;
        z-index: 1000;
        background-color: #198754;
        color: #fff;
        border-radius: 50%;
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        font-size: 1.8rem;
        transition: 0.3s ease;
    }

    .floating-download-btn:hover {
        background-color: #157347;
        transform: scale(1.05);
    }
</style>
<div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item">
                @isset($skema)
                    <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
                @else
                    <span>Form Perencanaan</span>
                @endisset
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.05 – Laporan Asesmen</li>
        </ol>
    </nav>
<div class="container mt-4">
    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.05 – LAPORAN ASESMEN (View Only)</h3>
    </div>

    <!-- SKEMA -->
    <div class="skema-container mb-3">
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
        <!-- Skema Sertifikasi -->
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

        <!-- Nomor Skema -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
            </div>
        </div>

        <!-- Nama Asesor -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label class="form-label">Nama Asesor</label>
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
                <label class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen" readonly>
            </div>
        </div>
    </div>
</div>
</div>

        <!-- Data Asesi -->
        <div class="card mapa-card mt-4">
            <div class="judul-box">
                <div class="judul-header">Data Asesi</div>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered custom-table text-center align-middle">
                        <thead class="table-title">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Asesi</th>
                                <th colspan="2">Rekomendasi</th>
                                <th rowspan="2">Keterangan</th>
                            </tr>
                            <tr>
                                <th>K</th>
                                <th>BK</th>
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
        <div class="card mapa-card mt-4">
            <div class="judul-box">
                <div class="judul-header">Catatan Asesmen</div>
                <div class="box">
                    <div class="box-header">Aspek Negatif dan Positif dalam Asesmen</div>
                    <textarea class="box-input" rows="3" id="aspek_positif_negatif" readonly></textarea>
                </div>
                <div class="box">
                    <div class="box-header">Pencatatan Penolakan Hasil Asesmen</div>
                    <textarea class="box-input" rows="3" id="penolakan" readonly></textarea>
                </div>
                <div class="box">
                    <div class="box-header">Saran Perbaikan : (Asesor/Personil Terkait)</div>
                    <textarea class="box-input" rows="3" id="saran_perbaikan" readonly></textarea>
                </div>
            </div>
        </div>
</div>

    <!-- Catatan & Tanda Tangan Asesor (View Only) -->
<div class="card mapa-card mt-4">
<div class="judul-box p-3">
        <div class="judul-header">Catatan & Tanda Tangan Asesor</div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Catatan</label>
            <textarea id="catatan_asesor" class="form-control" rows="3" readonly></textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Nama Asesor</label>
            <input type="text" id="nama_asesor_view" class="form-control" readonly>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Nomor Registrasi</label>
            <input type="text" id="no_registrasi_view" class="form-control" readonly>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Tanggal Asesmen</label>
            <input type="date" id="tanggal_asesmen_view" class="form-control" readonly>
        </div>

        <div class="col-md-12 mb-3 text-center">
            <label class="form-label">Tanda Tangan Asesor</label><br>
            <img id="ttd_asesor" src="" alt="TTD Asesor" style="max-width:300px; border:1px solid #ccc; display:none;">
            <p id="no_ttd_text" class="text-muted" style="display:none;">Belum ada tanda tangan.</p>
        </div>
    </div>
</div>
<!-- Floating Download Button -->
<a href="#" class="floating-download-btn" title="Download FR.AK.05 PDF">
    <i class="bi bi-download"></i>
</a>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const asesorSelect = document.getElementById('namaAsesor');
    const asesiTableBody = document.getElementById('asesiTableBody');

    asesorSelect.addEventListener('change', function() {
        const asesorId = this.value;
        if (!asesorId) {
            asesiTableBody.innerHTML = `<tr><td colspan="5">Silakan pilih asesor terlebih dahulu</td></tr>`;
            document.getElementById('aspek_positif_negatif').value = '';
            document.getElementById('penolakan').value = '';
            document.getElementById('saran_perbaikan').value = '';

            // reset bagian bawah (tanda tangan asesor)
            document.getElementById('catatan_asesor').value = '';
            document.getElementById('nama_asesor_view').value = '';
            document.getElementById('no_registrasi_view').value = '';
            document.getElementById('tanggal_asesmen_view').value = '';
            document.getElementById('ttd_asesor').style.display = 'none';
            document.getElementById('no_ttd_text').style.display = 'none';
            return;
        }

        const url = `{{ url('form-perencanaan/laporan/'.$skema->id_skema.'/asesi') }}/${asesorId}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const asesises = data.asesis;
                const catatan = data.catatan;

                asesiTableBody.innerHTML = '';
                if (asesises.length > 0) {
                    asesises.forEach((asesi, i) => {
                        let kChecked = asesi.hasil === 'K' ? 'checked' : '';
                        let bkChecked = asesi.hasil === 'BK' ? 'checked' : '';
                        let disabled = 'disabled';

                        let unitOptions = `<option value="">-- Pilih Unit --</option>`;
                        @foreach($skema->unitKompetensi as $unit)
                            unitOptions += `<option value="{{ $unit->id_unit }}" 
                                ${asesi.id_unit == {{ $unit->id_unit }} ? 'selected' : ''}>
                                {{ $unit->kode_unit }} - {{ $unit->judul_unit }}
                            </option>`;
                        @endforeach

                        asesiTableBody.innerHTML += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${asesi.nama_lengkap}</td>
                                <td><input type="radio" ${kChecked} ${disabled}></td>
                                <td><input type="radio" ${bkChecked} ${disabled}></td>
                                <td><select class="form-control" ${disabled}>${unitOptions}</select></td>
                            </tr>
                        `;
                    });
                } else {
                    asesiTableBody.innerHTML = `<tr><td colspan="5">Tidak ada asesi untuk asesor ini</td></tr>`;
                }

                document.getElementById('aspek_positif_negatif').value = catatan?.aspek_positif_negatif || '';
                document.getElementById('penolakan').value = catatan?.penolakan || '';
                document.getElementById('saran_perbaikan').value = catatan?.saran_perbaikan || '';

                // isi bagian bawah (tanda tangan asesor)
                document.getElementById('catatan_asesor').value = catatan?.catatan || '';
                document.getElementById('nama_asesor_view').value = asesorSelect.options[asesorSelect.selectedIndex].text;
                document.getElementById('no_registrasi_view').value = asesorSelect.options[asesorSelect.selectedIndex].dataset.no || '';
                document.getElementById('tanggal_asesmen_view').value = catatan?.tgl_laporan?.split('T')[0] || '';

                const ttdImg = document.getElementById('ttd_asesor');
                const noTtdText = document.getElementById('no_ttd_text');
                if (catatan?.tanda_tangan) {
                    ttdImg.src = catatan.tanda_tangan;
                    ttdImg.style.display = 'block';
                    noTtdText.style.display = 'none';
                } else {
                    ttdImg.style.display = 'none';
                    noTtdText.style.display = 'block';
                }
            })
            .catch(() => {
                asesiTableBody.innerHTML = `<tr><td colspan="5">Gagal memuat data</td></tr>`;
            });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const downloadBtn = document.querySelector('.floating-download-btn');
    const asesorSelect = document.getElementById('namaAsesor');

    downloadBtn.addEventListener('click', function(event) {
        event.preventDefault(); // hentikan dulu aksi default

        const asesorId = asesorSelect.value;
        if (!asesorId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Asesor Terlebih Dahulu',
                text: 'Silakan pilih nama asesor sebelum mendownload laporan.',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#198754'
            });
            return; // hentikan proses
        }

        // kalau sudah dipilih, lanjutkan download
        const skemaId = "{{ $skema->id_skema }}";
        const url = `{{ url('form-perencanaan/laporan/download') }}/${skemaId}/${asesorId}`;
        window.location.href = url;
    });
});
</script>

@endsection
