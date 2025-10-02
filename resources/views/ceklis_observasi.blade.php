@extends('master')

@section('konten')

<style>
    /* =========================
       Gaya Custom Form Ceklis
       ========================= */
    .content-card-custom {
        background-color: #FFFFFF;
        border: 1px solid #DEE2E6; 
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        overflow: hidden;
    }
    .header-group-blue-custom {
        background-color: #4C6EF5;
        color: white;
        padding: 0.75rem 1rem;
        font-weight: bold;
        font-size: 1.125rem;
    }
    .header-unit-light-blue-custom {
        background-color: #E6F0FF;
        border-left: 5px solid #4C6EF5;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-weight: 600;
        color: #212529;
    }
    .kuk-table-custom {
        border-collapse: collapse;
        font-size: 0.875rem;
        width: 100%;
    }
    .kuk-table-custom th, .kuk-table-custom td {
        border: 1px solid #DEE2E6;
        padding: 0.5rem 0.75rem;
        vertical-align: middle;
    }
    .kuk-table-custom thead th {
        background-color: #F8F9FA;
        font-weight: 600;
        color: #495057;
        text-align: left;
    }
    .kuk-table-custom tbody td:nth-child(1) {
        background-color: #F8F9FA;
        text-align: center;
        font-weight: 500;
    }
    .custom-radio {
        appearance: none;
        width: 1.15em;
        height: 1.15em;
        border: 2px solid #ADB5BD; 
        border-radius: 50%;
        display: block;
        margin: auto;
        cursor: pointer;
        transition: all 0.1s ease-in-out;
    }
    .custom-radio::before {
        content: "";
        display: block;
        width: 0.65em;
        height: 0.65em;
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.1s ease-in-out;
        margin: 0.15em;
    }
    .custom-radio[value="Ya"]:checked {
        border-color: #28A745;
        background-color: #28A745;
    }
    .custom-radio[value="Tidak"]:checked {
        border-color: #DC3545;
        background-color: #DC3545;
    }
    .custom-radio:checked::before {
        transform: scale(1);
        background-color: white;
    }
    .input-catatan-custom {
        border: 1px solid #CED4DA;
        padding: 0.375rem 0.5rem;
        border-radius: 0.2rem;
        font-size: 0.8rem;
        color: #495057;
    }
    .input-catatan-custom:focus {
        border-color: #80BDFF;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        outline: none;
    }
</style>

<div class="container mt-4">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Form Ceklis Observasi</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('ceklisobservasi.store') }}" method="POST" class="content-card-custom p-6">
        @csrf
        <div class="mb-5">
            <label for="id_asesi" class="font-semibold block mb-2 text-gray-700">Pilih Asesi</label>
            <select name="id_asesi" id="id_asesi" class="border border-gray-300 p-2.5 w-full rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-800" required>
                <option value="">-- pilih asesi --</option>
                @foreach($asesi as $a)
                    <option value="{{ $a->id_asesi }}">{{ $a->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>

        <h3 class="font-semibold mb-6 text-lg text-gray-800" id="nama-skema"></h3>

        <div id="kuk-container" class="space-y-8">
            <p class="text-gray-500 text-center">Pilih Asesi atau Skema untuk melihat daftar Kriteria Unjuk Kerja.</p>
        </div>

        <button type="submit" class="mt-8 bg-blue-600 text-white px-7 py-3 rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out text-lg font-medium shadow-md">
            Simpan Penilaian
        </button>
    </form>
</div>

<script>
function loadKuk(skemaId) {
    const container = document.getElementById('kuk-container');
    const namaSkemaEl = document.getElementById('nama-skema');
    container.innerHTML = '';
    namaSkemaEl.innerHTML = '';

    if (!skemaId) {
        container.innerHTML = '<p class="text-gray-500 text-center">Pilih Asesi atau Skema untuk melihat daftar Kriteria Unjuk Kerja.</p>';
        return;
    }

    fetch(`/ceklisobservasi/data/${skemaId}`)
        .then(res => res.json())
        .then(data => {
            if (!data.kelompok || data.kelompok.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center">Belum ada kelompok/unit untuk skema ini.</p>';
                return;
            }

            // Nama skema
            namaSkemaEl.innerHTML = data.kelompok?.[0]?.unit_kompetensi?.[0]?.skema_nama ?? 'Skema: Tidak tersedia';

            let html = '';

            data.kelompok.forEach((kel, kIndex) => {
                const namaKelompok = kel.nama_kelompok ?? 'Tidak ada nama kelompok';
                const idKelompok = kel.id_kelompok ?? 0;

                html += `
                <div class="content-card-custom mb-6">
                    <div class="header-group-blue-custom">
                        Kelompok Pekerjaan ${kIndex + 1}: ${namaKelompok}
                    </div>
                    <div class="p-5 space-y-4">`;

                (kel.unit_kompetensi ?? []).forEach(unit => {
                    const kodeUnit = unit.kode_unit ?? 'Kode Unit';
                    const judulUnit = unit.judul_unit ?? 'Judul Unit';

                    html += `
                    <div class="header-unit-light-blue-custom rounded-md">
                        <h2 class="font-semibold text-base">${kodeUnit} - ${judulUnit}</h2>
                    </div>`;

                    (unit.elemen ?? []).forEach(ele => {
                        const eleNomor = ele.nomor_elemen ?? '0';
                        const eleNama = ele.nama_elemen ?? 'Tidak ada nama elemen';
                        html += `
                        <div class="mb-5">
                            <h3 class="font-bold text-sm mb-3 text-gray-800">${eleNomor}. ${eleNama}</h3>
                            <table class="kuk-table-custom">
                                <thead>
                                    <tr>
                                        <th class="w-[5%] text-center">No.</th>
                                        <th class="w-[45%]">Kriteria Unjuk Kerja</th>
                                        <th class="w-[15%] text-center">Standar Industri</th>
                                        <th class="w-[8%] text-center">Ya</th>
                                        <th class="w-[8%] text-center">Tidak</th>
                                        <th class="w-[19%]">Penilaian Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        (ele.kuk ?? []).forEach((kuk, kukIndex) => {
                            const kukNo = `${eleNomor}.${kukIndex + 1}`;
                            const deskripsiKuk = kuk.deskripsi_kuk ?? 'Deskripsi KUK belum tersedia';
                            const kukId = kuk.id_kuk ?? 0;

                            html += `
                            <tr>
                                <td>${kukNo}</td>
                                <td>${deskripsiKuk}</td>
                                <td class="text-center text-xs font-medium text-gray-600">Modul Praktek</td>
                                <td class="text-center">
                                    <input type="radio" name="kuk[${kukId}][status]" value="Ya" class="custom-radio" required>
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="kuk[${kukId}][status]" value="Tidak" class="custom-radio">
                                </td>
                                <td>
                                    <input type="hidden" name="kuk[${kukId}][id_kelompok]" value="${idKelompok}">
                                    <input type="text" name="kuk[${kukId}][catatan]" placeholder="Catatan Penilaian" class="w-full input-catatan-custom">
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
            container.innerHTML = '<p class="text-red-600 text-center">Gagal memuat data. Coba refresh halaman.</p>';
        });
}

// Load otomatis dari query string ?id_skema=...
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const skemaId = urlParams.get('id_skema');
    if (skemaId) {
        loadKuk(skemaId);
    }
});
</script>

@endsection
