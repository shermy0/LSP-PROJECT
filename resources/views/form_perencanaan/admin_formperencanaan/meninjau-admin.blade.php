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

    /* Custom Checkbox Style */
    input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: #0d6efd !important;
        border-radius: 4px;
    }

    input[type="checkbox"]:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    input[type="checkbox"]:disabled:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
        opacity: 1 !important;
    }

    /* Tabel styling */
    .custom-table td {
        vertical-align: middle;
    }
    input[type="checkbox"]:disabled {
    opacity: 1 !important;
    filter: grayscale(0) !important;
    accent-color: #0d6efd !important;
    }
    input[type="checkbox"] {
        border: none !important;
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
            <li class="breadcrumb-item active" aria-current="page">FR.AK.06 – Meninjau Proses Asesmen</li>
        </ol>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.AK.06 – MENINJAU PROSES ASESMEN</h3>
            <p class="text-muted">Peninjauan Proses Asesmen</p>
        </div>

        <!-- SKEMA -->
        <div class="skema-container mb-3">
            <div class="skema-group">
                <span class="skema-label">SKEMA:</span>
                <span class="skema-select">{{ $skema->nama_skema }}</span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                    <div class="jenis-skema">
                        <input type="radio" id="kkni" name="skema_type" class="form-check-input me-2"
                               value="KKNI"
                               @if($skema->jenjang == 'KKNI') checked @endif disabled>
                        <label for="kkni">KKNI</label>

                        <input type="radio" id="okupasi" name="skema_type" class="form-check-input me-2"
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
        </div>

        <div class="row g-3">
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

            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="form-label">Tanggal Asesmen</label>
                    <input type="date" class="form-control" id="tanggalAsesmen" readonly>
                </div>
            </div>
        </div>

        <!-- TUK -->
        <div class="col-12 mt-3 mb-3">
            <div class="mapa-box">
                <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
                <div class="d-flex justify-content-start gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tuk_atas" id="tukSewaktuAtas" value="Sewaktu" disabled>
                        <label class="form-check-label" for="tukSewaktuAtas">Sewaktu</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tuk_atas" id="tukTempatKerjaAtas" value="Tempat Kerja" disabled>
                        <label class="form-check-label" for="tukTempatKerjaAtas">Tempat Kerja</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tuk_atas" id="tukMandiriAtas" value="Mandiri" checked disabled>
                        <label class="form-check-label" for="tukMandiriAtas">Mandiri</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Penjelasan -->
<div class="card mapa-card mt-4">
    <div class="judul-box">
        <div class="judul-header">Penjelasan</div>
        <ol class="penjelasan-list">
            <li>Peninjauan dapat dilakukan oleh lead asesor atau asesor yang melaksanakan asesmen.</li>
            <li>Peninjauan dapat dilakukan secara terpadu dalam skema sertifikasi dan / atau peserta kelompok yang homogen.</li>
            <li>Isilah pemenuhan dimensi kompetensi dengan menuliskan jenis bukti dan instrumen yang digunakan.</li>
        </ol>
    </div>
</div>

<!-- Kesesuaian dengan Prinsip Asesmen -->
<div class="card mapa-card mt-4">
    <div class="judul-box">
        <div class="judul-header">Kesesuaian dengan Prinsip Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">Aspek yang Ditinjau</th>
                        <th colspan="4" class="text-center">Kesesuaian dengan Prinsip Asesmen</th>
                    </tr>
                    <tr>
                        <th class="text-center">Validitas</th>
                        <th class="text-center">Reliabel</th>
                        <th class="text-center">Fleksibel</th>
                        <th class="text-center">Adil</th>
                    </tr>
                </thead>
                <tbody id="prinsipTableBody">
                    <tr>
                        <td colspan="5" class="text-center">Silakan pilih asesor terlebih dahulu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rekomendasi 1 -->
<div class="card mapa-card mt-4">
    <div class="judul-box">
        <div class="judul-header">Rekomendasi 1</div>
        <textarea class="box-input" rows="3" id="rekomendasi1" readonly></textarea>
    </div>
</div>

<!-- Pemenuhan Dimensi Kompetensi -->
<div class="card mapa-card mt-4">
    <div class="judul-box">
        <div class="judul-header">Pemenuhan Dimensi Kompetensi</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table text-center align-middle">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="align-middle">Aspek yang Ditinjau</th>
                        <th colspan="5">Pemenuhan dimensi kompetensi</th>
                    </tr>
                    <tr>
                        <th>Task Skills</th>
                        <th>Task Management Skills</th>
                        <th>Contingency Management Skills</th>
                        <th>Job Role/Environment Skills</th>
                        <th>Transfer Skills</th>
                    </tr>
                </thead>
                <tbody id="dimensiTableBody">
                    <tr>
                        <td colspan="6">Silakan pilih asesor terlebih dahulu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rekomendasi 2 -->
<div class="card mapa-card mt-4">
    <div class="judul-box">
        <div class="judul-header">Rekomendasi 2</div>
        <textarea class="box-input" rows="3" id="rekomendasi2" readonly></textarea>
    </div>
</div>

<!-- Tanda Tangan Asesor (View Only) -->
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
<a href="#" class="floating-download-btn" title="Download FR.AK.06 PDF">
    <i class="bi bi-download"></i>
</a>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const asesorSelect = document.getElementById('namaAsesor');
    const prinsipTableBody = document.getElementById('prinsipTableBody');
    const dimensiTableBody = document.getElementById('dimensiTableBody');

    // Data aspek untuk tabel prinsip
    const aspekPrinsip = [
        { nama: 'Rencana asesmen', validitas: true, reliabel: true, fleksibel: true, adil: true },
        { nama: 'Persiapan asesmen', validitas: true, reliabel: true, fleksibel: true, adil: true },
        { nama: 'Implementasi asesmen', validitas: true, reliabel: true, fleksibel: true, adil: true },
        { nama: 'Keputusan asesmen', validitas: true, reliabel: true, fleksibel: false, adil: true },
        { nama: 'Umpan balik asesmen', validitas: true, reliabel: true, fleksibel: false, adil: true }
    ];

    // Data aspek untuk tabel dimensi
    const aspekDimensi = [
        'Konsistensi keputusan asesmen',
        'Bukti dari berbagai asesmen diperiksa untuk konsistensi dimensi kompetensi'
    ];

    const dimensiKolom = ['task', 'task_mgmt', 'contingency', 'jobrole', 'transfer'];
    const options = ['L', 'CL', 'T', 'DPT'];

    asesorSelect.addEventListener('change', function() {
        const asesorId = this.value;
        if (!asesorId) {
            prinsipTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Silakan pilih asesor terlebih dahulu</td></tr>`;
            dimensiTableBody.innerHTML = `<tr><td colspan="6">Silakan pilih asesor terlebih dahulu</td></tr>`;
            document.getElementById('rekomendasi1').value = '';
            document.getElementById('rekomendasi2').value = '';
            document.getElementById('catatan_asesor').value = '';
            document.getElementById('nama_asesor_view').value = '';
            document.getElementById('no_registrasi_view').value = '';
            document.getElementById('tanggal_asesmen_view').value = '';
            document.getElementById('ttd_asesor').style.display = 'none';
            document.getElementById('no_ttd_text').style.display = 'none';
            return;
        }

        const url = `/form-perencanaan/meninjau-proses/{{ $skema->id_skema }}/data/${asesorId}`;
        fetch(url)
        .then(res => res.json())
        .then(data => {
            const prinsip = data.prinsip || {};
            const dimensi = data.dimensi || {};
            const tandaTangan = data.tanda_tangan || null;

            // Cek apakah data benar-benar kosong
            const isPrinsipEmpty = Object.keys(prinsip).length === 0;
            const isDimensiEmpty = Object.keys(dimensi).length === 0;
            
            if (isPrinsipEmpty && isDimensiEmpty) {
                // Tampilkan pesan "tidak ada data"
                prinsipTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>`;
                dimensiTableBody.innerHTML = `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`;
                document.getElementById('rekomendasi1').value = '';
                document.getElementById('rekomendasi2').value = '';
                document.getElementById('catatan_asesor').value = '';
                document.getElementById('nama_asesor_view').value = '';
                document.getElementById('no_registrasi_view').value = '';
                document.getElementById('tanggal_asesmen_view').value = '';
                document.getElementById('ttd_asesor').style.display = 'none';
                document.getElementById('no_ttd_asesor').style.display = 'block';
                return; // Keluar dari fungsi
            }

            // Isi tabel prinsip asesmen
            prinsipTableBody.innerHTML = '';
            aspekPrinsip.forEach((aspek, i) => {
                const prefix = ['rencana', 'pertukar', 'implementasi', 'keputusan', 'umpan'][i];
                prinsipTableBody.innerHTML += `
                    <tr>
                        <td>${aspek.nama}</td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" ${prinsip[prefix + '_validitas'] ? 'checked' : ''} disabled ${!aspek.validitas ? 'style="visibility:hidden"' : ''}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" ${prinsip[prefix + '_reliabel'] ? 'checked' : ''} disabled ${!aspek.reliabel ? 'style="visibility:hidden"' : ''}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" ${prinsip[prefix + '_fleksibel'] ? 'checked' : ''} disabled ${!aspek.fleksibel ? 'style="visibility:hidden"' : ''}>
                        </td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" ${prinsip[prefix + '_adil'] ? 'checked' : ''} disabled ${!aspek.adil ? 'style="visibility:hidden"' : ''}>
                        </td>
                    </tr>
                `;
            });

            // Isi tabel dimensi kompetensi
            dimensiTableBody.innerHTML = '';
            aspekDimensi.forEach((namaAspek, i) => {
                const prefix = i === 0 ? 'konsistensi' : 'bukti';
                let row = `<tr><td class="text-start">${namaAspek}</td>`;
                
                dimensiKolom.forEach(kolom => {
                    const key = `${prefix}_${kolom}`;
                    const values = dimensi[key] || [];
                    let cellContent = '';
                    
                    options.forEach(opt => {
                        const isChecked = values.includes(opt);
                        cellContent += `<label><input class="form-check-input" type="checkbox" ${isChecked ? 'checked' : ''} disabled> ${opt}</label><br>`;
                    });
                    
                    row += `<td>${cellContent}</td>`;
                });
                
                row += `</tr>`;
                dimensiTableBody.innerHTML += row;
            });

            // Isi rekomendasi
            document.getElementById('rekomendasi1').value = data.rekomendasi1 || '';
            document.getElementById('rekomendasi2').value = data.rekomendasi2 || '';

            // Isi bagian tanda tangan
            document.getElementById('catatan_asesor').value = tandaTangan?.catatan || '';
            document.getElementById('nama_asesor_view').value = asesorSelect.options[asesorSelect.selectedIndex].text;
            document.getElementById('no_registrasi_view').value = asesorSelect.options[asesorSelect.selectedIndex].dataset.no || '';
            document.getElementById('tanggal_asesmen_view').value = tandaTangan?.tanggal?.split('T')[0] || '';

            const ttdImg = document.getElementById('ttd_asesor');
            const noTtdText = document.getElementById('no_ttd_text');
            if (tandaTangan?.tanda_tangan) {
                ttdImg.src = tandaTangan.tanda_tangan;
                ttdImg.style.display = 'block';
                noTtdText.style.display = 'none';
            } else {
                ttdImg.style.display = 'none';
                noTtdText.style.display = 'block';
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            prinsipTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>`;
            dimensiTableBody.innerHTML = `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`;
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const downloadBtn = document.querySelector('.floating-download-btn');
    const asesorSelect = document.getElementById('namaAsesor');

    downloadBtn.addEventListener('click', function(event) {
        event.preventDefault();

        const asesorId = asesorSelect.value;
        if (!asesorId) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Asesor Terlebih Dahulu',
                text: 'Silakan pilih nama asesor sebelum mendownload.',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#198754'
            });
            return;
        }

        const skemaId = "{{ $skema->id_skema }}";
        const url = `{{ url('form-perencanaan/meninjau-proses/download') }}/${skemaId}/${asesorId}`;
        window.location.href = url;
    });
});
</script>

@endsection