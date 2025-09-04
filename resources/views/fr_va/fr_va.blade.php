@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.VA {{ $periode }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.VA – MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>
        <small class="text-muted">Pemberian Kontribusi dalam Validasi Asesmen</small>
    </div>

    <!-- Periode -->
    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label">PERIODE:</span>
            <span class="skema-select text-primary fw-bold">{{ $periodeText }}</span>
        </div>
    </div>

    <!-- Form -->
    <form class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="nomor" class="form-label">Nomor</label>
                <input type="text" class="form-control" id="nomor" placeholder="Nomor Skema" readonly>
            </div>
            <div class="col-md-4">
                <label for="tempat" class="form-label">Tempat</label>
                <input type="text" class="form-control" id="tempat" placeholder="Tempat Asesmen" readonly>
            </div>
            <div class="col-md-4">
                <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen">
            </div>
        </div>
    </form>
</div>

<div class="card-box">
    <!-- 1. Menyiapkan Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box">
            <div class="judul-header">1. Menyiapkan Proses Validasi</div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Tujuan dan Fokus Validasi</th>
                        <th class="text-center">Konteks Validasi</th>
                        <th class="text-center">Pendekatan Validasi</th>
                    </tr>
                </thead>
                <tbody id="validasi-body"></tbody>
            </table>
        </div>
    </div>

    <!-- Orang yang Relevan -->
    <div class="card-box mb-4">
        <div class="judul-box">
            <div class="judul-header">Orang yang Relevan</div>
        </div>

        <!-- Asesor Kompetensi -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="asesorCheckbox" data-target="asesorForm">
                <label class="form-check-label fw-bold" for="asesorCheckbox">Asesor Kompetensi (wajib)</label>
            </div>
            <div id="asesorForm" class="mt-2" style="display:none;"></div>
        </div>

        <!-- Lead Asesor -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="leadCheckbox" data-target="leadForm">
                <label class="form-check-label" for="leadCheckbox">Lead Asesor [Ketua TUK]</label>
            </div>
            <div id="leadForm" class="mt-2" style="display:none;"></div>
        </div>

        <!-- Manager -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="managerCheckbox" data-target="managerForm">
                <label class="form-check-label" for="managerCheckbox">Manager, Supervisor</label>
            </div>
            <div id="managerForm" class="mt-2" style="display:none;"></div>
        </div>

        <!-- Tenaga Ahli -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="ahliCheckbox" data-target="ahliForm">
                <label class="form-check-label" for="ahliCheckbox">Tenaga Ahli di bidangnya</label>
            </div>
            <div id="ahliForm" class="mt-2" style="display:none;"></div>
        </div>

        <!-- Koordinator Pelatihan -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="koordinatorCheckbox" data-target="koordinatorForm">
                <label class="form-check-label" for="koordinatorCheckbox">Koordinator Pelatihan</label>
            </div>
            <div id="koordinatorForm" class="mt-2" style="display:none;"></div>
        </div>

        <!-- Anggota Asosiasi -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="anggotaCheckbox" data-target="anggotaForm">
                <label class="form-check-label" for="anggotaCheckbox">Anggota Asosiasi Industry Profesi</label>
            </div>
            <div id="anggotaForm" class="mt-2" style="display:none;"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function getFormHTML(name) {
        return `
        <div class="border p-2 rounded">
            <div id="${name}-namaList">
                <div class="input-group mb-2">
                    <input type="text" name="${name}_nama[]" class="form-control" placeholder="Masukkan nama">
                    <button class="btn btn-danger removeNama" type="button"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <button type="button" class="btn btn-success btn-sm mb-3 addNama" data-target="${name}-namaList">+ Tambah nama</button><br>
            <label class="form-label">Hasil konfirmasi/diskusi</label>
            <textarea name="${name}_diskusi" class="form-control" rows="2" placeholder="Masukkan hasil diskusi"></textarea>
        </div>`;
    }

    document.querySelectorAll(".toggle-section").forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            const target = document.getElementById(this.dataset.target);
            if (this.checked) {
                target.innerHTML = getFormHTML(this.id);
                target.style.display = "block";

                target.addEventListener("click", function(e) {
                    if (e.target.classList.contains("addNama")) {
                        const list = document.getElementById(e.target.dataset.target);
                        const div = document.createElement("div");
                        div.classList.add("input-group", "mb-2");
                        div.innerHTML = `
                            <input type="text" name="${checkbox.id}_nama[]" class="form-control" placeholder="Masukkan nama">
                            <button class="btn btn-danger removeNama" type="button"><i class="fa fa-trash"></i></button>`;
                        list.appendChild(div);
                    }

                    if (e.target.classList.contains("removeNama") || e.target.closest(".removeNama")) {
                        e.target.closest(".input-group").remove();
                    }
                });
            } else {
                target.innerHTML = "";
                target.style.display = "none";
            }
        });
    });
});
</script>

<!-- Acuan Pembanding -->
<div class="card-box">
    <div class="table-responsive mt-4">
        <table class="table custom-table">
            <thead class="table-title">
                <tr>
                    <th class="text-center">Acuan Pembanding</th>
                    <th class="text-center">Dokumen Terkait dan Bahan-bahan</th>
                </tr>
            </thead>
            <tbody id="acuan-body"></tbody>
        </table>
    </div>
</div>

<div class="card-box mb-4">
    <!-- 2. Memberikan Kontribusi dalam Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box">
            <div class="judul-header">2. Memberikan Kontribusi dalam Proses Validasi</div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Acuan Pembanding</th>
                        <th class="text-center">Dokumen Terkait dan Bahan-bahan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Keterampilan komunikasi yang digunakan dalam kegiatan validasi :</td>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="proAktif">
                                <label class="form-check-label" for="proAktif">Pro Aktif</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="activeListening">
                                <label class="form-check-label" for="activeListening">Active Listening</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="empati">
                                <label class="form-check-label" for="empati">Empati</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-box mb-4">
        <div class="judul-header">Aspek dalam Kegiatan </div>
        <table class="table custom-table">
            <thead class="table-title">
                <tr>
                    <th rowspan="3" class="text-center align-middle">No</th>
                    <th rowspan="3" class="text-center align-middle">
                        Aspek dalam Kegiatan Validasi <br>
                        (Meninjau, Membandingkan, Mengevaluasi)
                    </th>
                    <th colspan="8" class="text-center">Pemenuhan Terhadap</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Aturan Bukti</th>
                    <th colspan="4" class="text-center">Prinsip Asesmen</th>
                </tr>
                <tr>
                    <th class="text-center">V</th>
                    <th class="text-center">A</th>
                    <th class="text-center">T</th>
                    <th class="text-center">M</th>
                    <th class="text-center">V</th>
                    <th class="text-center">R</th>
                    <th class="text-center">F</th>
                    <th class="text-center">F</th>
                </tr>
            </thead>

            @php
                $aspek = [
                    'Rencana Asesmen',
                    'Interpretasi Standar Kompetensi',
                    'Interpretasi Acuan Pembanding lainnya',
                    'Proses Asesmen',
                    'Penyeleksian dan Penerapan Metode Asesmen',
                    'Penyeleksian dan Penerapan Perangkat Asesmen',
                    'Bukti-bukti yang Dikumpulkan',
                    'Pengambilan Keputusan'
                ];

                $disabledCells = [
                    [7, 7],
                    [8, 7],
                ];
            @endphp

            @foreach ($aspek as $i => $item)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $item }}</td>
                @for ($j = 1; $j <= 8; $j++)
                    <td class="text-center">
                        @if(in_array([$i+1, $j], $disabledCells))
                            <input type="checkbox" class="custom-checkbox red-disabled" disabled>
                        @else
                            <input type="checkbox" name="aspek[{{ $i }}][{{ $j }}]" class="custom-checkbox">
                        @endif
                    </td>
                @endfor
            </tr>
            @endforeach
        </table>
    </div>
</div>

<form id="simpan-form" action="{{ route('fr_va_asesor.simpan') }}" method="POST" class="simpan-form">
    @csrf
    <input type="hidden" name="periode" value="{{ $periode }}">
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
const validasiData = [
    { tujuan: "Bagian dari Proses Penjaminan Mutu Organisasi", konteks: "Internal Organisasi", pendekatan: "Internal Organisasi" },
    { tujuan: "Mengantisipasi Risiko", konteks: "Eksternal Organisasi", pendekatan: "Pertemuan Moderasi" },
    { tujuan: "Memenuhi Persyaratan BNSP", konteks: "Proses Lisensi / Re-Lisensi", pendekatan: "Mengkaji Perangkat Asesmen" },
    { tujuan: "Memastikan Kesesuaian Bukti", konteks: "Dengan Kolega Asesor", pendekatan: "Acuan Pembanding" },
    { tujuan: "Meningkatkan Kualitas Asesmen", konteks: "Kolega dari Organisasi Pelatihan atau Asesmen", pendekatan: "Pengujian lapangan dan uji coba perangkat asesmen" },
    { tujuan: "Mengevaluasi Kualitas Perangkat Asesmen", konteks: "Masukkan Konteks lain", pendekatan: "Umpan Balik dari Klien", otherKonteks: true },
    { tujuan: "Masukkan Tujuan lain", konteks: "Masukkan Konteks lain", pendekatan: "Mengkaji Bukti-bukti", other: true }
];

const acuanData = {
    acuan: [
        "Standar Kompetensi (SKKNI/SKKK/SKI)",
        "Skema Sertifikasi",
        "SOP/IK",
        "Manual Instruction / Book Manual",
        "Standar Kinerja"
    ],
    dokumen: [
        "Perangkat Asesmen",
        "Peraturan / Pedoman",
        "Bukti-bukti hasil asesmen",
        { other: "Masukkan dokumen lain", id: "dokumenLain1" },
        { other: "Masukkan dokumen lain", id: "dokumenLain2" }
    ]
};

function createCheckbox(text, id=null, withInput=false) {
    if (withInput) {
        return `
            <div class="form-check with-input">
                <input type="checkbox" class="form-check-input toggle-input" data-target="${id}" id="${id}-chk">
                <input type="text" id="${id}" placeholder="${text}" disabled>
            </div>`;
    }
    return `
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="${text}">
            <label class="form-check-label" for="${text}">${text}</label>
        </div>`;
}

const validasiBody = document.getElementById("validasi-body");
validasiData.forEach((row, index) => {
    validasiBody.innerHTML += `
        <tr>
            <td>${row.other ? createCheckbox(row.tujuan, "tujuanLain", true) : createCheckbox(row.tujuan)}</td>
            <td>${row.otherKonteks || row.other ? createCheckbox(row.konteks, "konteksLain${index}", true) : createCheckbox(row.konteks)}</td>
            <td>${createCheckbox(row.pendekatan)}</td>
        </tr>`;
});

const acuanBody = document.getElementById("acuan-body");
for (let i = 0; i < Math.max(acuanData.acuan.length, acuanData.dokumen.length); i++) {
    const acuan = acuanData.acuan[i] ? createCheckbox(acuanData.acuan[i]) : "";
    const dokumen = acuanData.dokumen[i]
        ? (typeof acuanData.dokumen[i] === "string"
            ? createCheckbox(acuanData.dokumen[i])
            : createCheckbox(acuanData.dokumen[i].other, acuanData.dokumen[i].id, true))
        : "";
    acuanBody.innerHTML += `<tr><td>${acuan}</td><td>${dokumen}</td></tr>`;
}

document.addEventListener("change", function(e) {
    if (e.target.classList.contains("toggle-input")) {
        const input = document.getElementById(e.target.dataset.target);
        if (input) {
            input.disabled = !e.target.checked;
            if (!e.target.checked) input.value = "";
        }
    }
});
</script>
@endsection
