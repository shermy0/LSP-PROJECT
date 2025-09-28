@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.VA {{ $periode }}</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.VA – MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>
    </div>

    <!-- Periode -->
    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">PERIODE:</span>
            <span class="text-primary fw-bold">{{ $periodeText }}</span>
        </div>
    </div>

    <!-- Form Asesmen -->
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
        <div class="judul-box"><div class="judul-header">1. Menyiapkan Proses Validasi</div></div>
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
        <div class="judul-box"><div class="judul-header">Orang yang Relevan</div></div>

        @php
            $orangRelevan = [
                'asesorCheckbox' => 'Asesor Kompetensi (wajib)',
                'leadCheckbox' => 'Lead Asesor [Ketua TUK]',
                'managerCheckbox' => 'Manager, Supervisor',
                'ahliCheckbox' => 'Tenaga Ahli di bidangnya',
                'koordinatorCheckbox' => 'Koordinator Pelatihan',
                'anggotaCheckbox' => 'Anggota Asosiasi Industry Profesi'
            ];
        @endphp

        @foreach($orangRelevan as $id => $label)
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" id="{{ $id }}" data-target="{{ $id }}Form">
                <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
            </div>
            <div id="{{ $id }}Form" class="mt-2" style="display:none;"></div>
        </div>
        @endforeach
    </div>

    <!-- Acuan Pembanding -->
    <div class="card-box mb-4">
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

    <!-- 2. Memberikan Kontribusi dalam Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box"><div class="judul-header">2. Memberikan Kontribusi dalam Proses Validasi</div></div>
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
                            @php
                                $skills = ['Pro Aktif','Active Listening','Empati'];
                            @endphp
                            @foreach($skills as $skill)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="{{ $skill }}">
                                <label class="form-check-label" for="{{ $skill }}">{{ $skill }}</label>
                            </div>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aspek Kegiatan -->
    <div class="card-box mb-4">
        <div class="judul-header">Aspek dalam Kegiatan </div>
        <table class="table custom-table">
            <thead class="table-title">
                <tr>
                    <th rowspan="3" class="text-center align-middle">No</th>
                    <th rowspan="3" class="text-center align-middle">Aspek dalam Kegiatan Validasi <br>(Meninjau, Membandingkan, Mengevaluasi)</th>
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
            <tbody>
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
                    $disabledCells = [[7,7],[8,7]];
                @endphp
                @foreach($aspek as $i => $item)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td>{{ $item }}</td>
                    @for($j=1;$j<=8;$j++)
                        <td class="text-center">
                            @if(in_array([$i+1,$j], $disabledCells))
                                <input type="checkbox" class="custom-checkbox red-disabled" disabled>
                            @else
                                <input type="checkbox" name="aspek[{{ $i }}][{{ $j }}]" class="custom-checkbox">
                            @endif
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Form Submit -->
<form id="simpan-form" action="{{ route('fr_va_asesor.simpan') }}" method="POST" class="simpan-form">
    @csrf
    <input type="hidden" name="periode" value="{{ $periode }}">
    <button type="submit" class="simpan-btn"><span>Simpan dan Lanjut</span></button>
</form>

<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

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
        if(withInput){
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

    // Render Validasi
    const validasiBody = document.getElementById("validasi-body");
    validasiData.forEach((row,index)=>{
        validasiBody.innerHTML += `
            <tr>
                <td>${row.other ? createCheckbox(row.tujuan,"tujuanLain",true): createCheckbox(row.tujuan)}</td>
                <td>${row.otherKonteks || row.other ? createCheckbox(row.konteks,"konteksLain${index}",true): createCheckbox(row.konteks)}</td>
                <td>${createCheckbox(row.pendekatan)}</td>
            </tr>`;
    });

    // Render Acuan Pembanding
    const acuanBody = document.getElementById("acuan-body");
    for(let i=0; i<Math.max(acuanData.acuan.length, acuanData.dokumen.length); i++){
        const acuan = acuanData.acuan[i] ? createCheckbox(acuanData.acuan[i]) : "";
        const dokumen = acuanData.dokumen[i]
            ? (typeof acuanData.dokumen[i]==="string"?createCheckbox(acuanData.dokumen[i]):createCheckbox(acuanData.dokumen[i].other, acuanData.dokumen[i].id,true))
            : "";
        acuanBody.innerHTML += `<tr><td>${acuan}</td><td>${dokumen}</td></tr>`;
    }

    // Toggle Section
    function getFormHTML(name){
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

    document.querySelectorAll(".toggle-section").forEach(checkbox=>{
        checkbox.addEventListener("change",function(){
            const target = document.getElementById(this.dataset.target);
            if(this.checked){
                target.innerHTML = getFormHTML(this.id);
                target.style.display="block";

                target.addEventListener("click",function(e){
                    if(e.target.classList.contains("addNama")){
                        const list = document.getElementById(e.target.dataset.target);
                        const div = document.createElement("div");
                        div.classList.add("input-group","mb-2");
                        div.innerHTML = `
                            <input type="text" name="${checkbox.id}_nama[]" class="form-control" placeholder="Masukkan nama">
                            <button class="btn btn-danger removeNama" type="button"><i class="fa fa-trash"></i></button>`;
                        list.appendChild(div);
                    }
                    if(e.target.classList.contains("removeNama") || e.target.closest(".removeNama")){
                        e.target.closest(".input-group").remove();
                    }
                });
            } else {
                target.innerHTML="";
                target.style.display="none";
            }
        });
    });

    // Toggle Input
    document.addEventListener("change",function(e){
        if(e.target.classList.contains("toggle-input")){
            const input = document.getElementById(e.target.dataset.target);
            if(input){
                input.disabled = !e.target.checked;
                if(!e.target.checked) input.value="";
            }
        }
    });
});
</script>
@endsection
