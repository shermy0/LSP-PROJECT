@extends('master')

@section('konten')

<div class="container mt-4">
    <h1 class="fw-bold mb-4 text-dark">Form Ceklis Observasi</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('ceklisobservasi.store') }}" method="POST" class="card shadow-sm p-4">
        @csrf

        <input type="hidden" name="id_skema" value="{{ request('id_skema') }}">
        <input type="hidden" name="id_asesmen" value="{{ $asesmen->id_asesmen ?? '' }}">

        <!-- Pilih Asesi -->
        <div class="mb-4">
            <label for="id_asesi" class="form-label fw-semibold">Pilih Asesi</label>
            <select name="id_asesi" id="id_asesi" class="form-select" required>
                <option value="">-- pilih asesi --</option>
                @foreach($asesi as $a)
                    <option value="{{ $a->id_asesi }}">{{ $a->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nama skema -->
        <h3 class="fw-semibold mb-4 text-primary" id="nama-skema">Skema: -</h3>

        <!-- Container dinamis -->
        <div id="kuk-container" class="text-center text-muted">
            Pilih Asesi atau Skema untuk melihat daftar Kriteria Unjuk Kerja.
        </div>

        <!-- Field tambahan (UMPAN BALIK & REKOMENDASI pindah ke bawah KUK) -->
        <div class="mb-4 mt-4">
            <label for="umpan_balik" class="form-label fw-semibold">Umpan Balik</label>
            <textarea name="umpan_balik" id="umpan_balik" class="form-control"></textarea>
        </div>
        <div class="mb-4">
            <label for="rekomendasi" class="form-label fw-semibold">Rekomendasi</label>
            <select name="rekomendasi" id="rekomendasi" class="form-select" required>
                <option value="">-- pilih rekomendasi --</option>
                <option value="Kompeten">Kompeten</option>
                <option value="Belum Kompeten">Belum Kompeten</option>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary btn-lg mt-4">
            Simpan Penilaian
        </button>
    </form>
</div>

<style>
    .header-group {
        background-color: #4C6EF5;
        color: #fff;
        padding: .75rem 1rem;
        font-weight: 600;
        border-radius: .25rem .25rem 0 0;
    }
    .header-unit {
        background-color: #E6F0FF;
        border-left: 5px solid #4C6EF5;
        padding: .75rem 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .form-check-input:checked[value="Ya"] {
        background-color: #28a745;
        border-color: #28a745;
    }
    .form-check-input:checked[value="Tidak"] {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<script>
function loadKuk(skemaId) {
    const container = document.getElementById('kuk-container');
    const namaSkemaEl = document.getElementById('nama-skema');
    container.innerHTML = '';
    namaSkemaEl.innerHTML = '';

    if (!skemaId) {
        container.innerHTML = '<p class="text-muted">Pilih Asesi atau Skema untuk melihat daftar Kriteria Unjuk Kerja.</p>';
        return;
    }

    fetch(`/ceklisobservasi/data/${skemaId}`)
    .then(res => res.json())
    .then(data => {
        namaSkemaEl.innerHTML = "Skema: " + (data.skema_nama ?? 'Tidak tersedia');

        if (!data.kelompok || data.kelompok.length === 0) {
            container.innerHTML = '<p class="text-muted">Belum ada kelompok/unit untuk skema ini.</p>';
            return;
        }

        let html = '';
        data.kelompok.forEach((kel, kIndex) => {
            const namaKelompok = kel.nama_kelompok ?? 'Tidak ada nama kelompok';
            const idKelompok = kel.id_kelompok ?? 0;

            html += `
            <div class="card mb-4 shadow-sm">
                <div class="header-group">Kelompok Pekerjaan ${kIndex + 1}: ${namaKelompok}</div>
                <div class="card-body">`;

            (kel.unit_kompetensi ?? []).forEach(unit => {
                html += `
                <div class="header-unit mb-3">
                    ${unit.kode_unit ?? 'Kode Unit'} - ${unit.judul_unit ?? 'Judul Unit'}
                </div>`;

                (unit.elemen ?? []).forEach(ele => {
                    html += `
                    <h6 class="fw-bold mb-3">${ele.nomor_elemen ?? '0'}. ${ele.nama_elemen ?? '-'}</h6>
                    <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No.</th>
                                <th style="width:35%">Kriteria Unjuk Kerja</th>
                                <th style="width:20%">Standar Industri</th>
                                <th style="width:8%">Ya</th>
                                <th style="width:8%">Tidak</th>
                                <th style="width:24%">Penilaian Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    (ele.kuk ?? []).forEach((kuk, kukIndex) => {
                        const kukNo = `${ele.nomor_elemen || kIndex + 1}.${kukIndex + 1}`;
                        const kukId = kuk.id_kuk ?? 0;
                        const elemenId = ele.id_elemen ?? '';
                        const unitId = unit.id_unit ?? '';

                        html += `
                        <tr>
                            <td>${kukNo}</td>
                            <td>${kuk.deskripsi_kuk ?? '-'}</td>
                            <td>
                                <select class="form-select form-select-sm standar-industri" 
                                        name="kuk[${kukId}][standar]" 
                                        onchange="toggleLainnya(this, ${kukId})">
                                        <option value="Modul Praktek">Modul Praktek</option>
                                    <option value="SOP">SOP</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <input type="text" 
                                       class="form-control form-control-sm mt-2 d-none" 
                                       name="kuk[${kukId}][standar_lainnya]" 
                                       placeholder="Tulis standar lainnya">
                            </td>
                            <td class="text-center">
                                <input class="form-check-input" type="radio" name="kuk[${kukId}][status]" value="Ya" required>
                            </td>
                            <td class="text-center">
                                <input class="form-check-input" type="radio" name="kuk[${kukId}][status]" value="Tidak">
                            </td>
                            <td>
                                <input type="hidden" name="kuk[${kukId}][id_kelompok]" value="${idKelompok}">
                                <input type="hidden" name="kuk[${kukId}][id_elemen]" value="${elemenId}">
                                <input type="hidden" name="kuk[${kukId}][id_unit]" value="${unitId}">
                                <input type="text" name="kuk[${kukId}][catatan]" class="form-control form-control-sm" placeholder="Catatan Penilaian">
                            </td>
                        </tr>`;
                    });

                    html += `</tbody></table></div>`;
                });
            });

            html += `</div></div>`;
        });

        container.innerHTML = html;
    })
    .catch(err => {
        console.error("Error loading KUK data:", err);
        container.innerHTML = '<p class="text-danger">Gagal memuat data. Coba refresh halaman.</p>';
    });
}

function toggleLainnya(selectEl, kukId) {
    const inputLainnya = selectEl.parentElement.querySelector('input[name="kuk['+kukId+'][standar_lainnya]"]');
    if (selectEl.value === "Lainnya") {
        inputLainnya.classList.remove("d-none");
    } else {
        inputLainnya.classList.add("d-none");
        inputLainnya.value = "";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const skemaId = urlParams.get('id_skema');
    if (skemaId) {
        loadKuk(skemaId);
    }
});
</script>
@endsection
