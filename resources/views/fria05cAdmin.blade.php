@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05cAdmin.css') }}">

<div class="form-asesmen-header">
    <p class="breadcrumb">Form Asesmen ></p>
    <div class="icon-box"></div>
    <h1 class="main-title">FR.IA.05.C. LEMBAR JAWABAN PILIHAN GANDA</h1>
    <p class="sub-title">Kunci Jawaban untuk Tes Tertulis Pilihan Ganda</p>
    <div class="skema-box">
        <span class="skema-text">ANSWER KEY FORM</span>
    </div>
</div>

{{-- ================= FORM BIODATA ================= --}}
<div class="section-box">
    <div class="form-group">
        <label for="no_form">No.Form</label>
        <input type="text" class="form-control" name="no_form" placeholder="Masukkan No.Form">
    </div>

    <div class="form-group">
        <label for="judul_skema">Judul Skema Sertifikasi</label>
        <input type="text" class="form-control" name="judul_skema" placeholder="Masukkan Judul Skema Sertifikasi">
    </div>

    <div class="form-group">
        <label for="nama_asesor">Nama Asesor</label>
        <input type="text" class="form-control" name="nama_asesor" placeholder="Masukkan nama asesor">
    </div>

    <div class="form-group">
        <label for="nama_asesi">Nama Asesi</label>
        <input type="text" class="form-control" name="nama_asesi" placeholder="Masukkan nama asesi">
    </div>

    <div class="form-group">
        <label for="tanggal_asesmen">Tanggal Asesmen</label>
        <input type="date" class="form-control" name="tanggal_asesmen">
    </div>

    <div class="form-group">
        <label for="tuk">TUK (Tempat Uji Kompetensi)</label>
        <input type="text" class="form-control" name="tuk" value="SMKN 11 Bandung">
    </div>
</div>

{{-- ================= BAGIAN PERTANYAAN ================= --}}
<div class="section-box">
    <div class="table-wrapper">
        <div class="header">
            <div class="header-strip"></div>
            <h2 class="header-title">Lembar Jawaban Pertanyaan Tertulis– Pilihan Ganda</h2>
        </div>

        <table class="table-jawaban">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jawaban</th>
                    <th>Ya</th>
                    <th>Tidak</th>
                </tr>
            </thead>
            <tbody id="jawabanTableBody">
                <!-- isi otomatis dari JS -->
            </tbody>
        </table>
    </div>
</div>

{{-- ================= UMPAN BALIK ================= --}}
<div class="section-box">
    <div class="table-wrapper">
        <div class="header">
            <div class="header-strip"></div>
            <h2 class="header-title">Umpan Balik untuk Asesi</h2>
        </div>

        <div class="box-title">
            Aspek pengetahuan seluruh unit kompetensi yang diujikan (tercapai/ belum tercapai)*
        </div>

        <div class="form-group">
            <textarea class="form-textarea" name="umpan_balik" placeholder="Tuliskan unit/elemen/KUK jika belum tercapai …."></textarea>
        </div>
    </div>
</div>

{{-- ================= TANDA TANGAN ================= --}}
<div class="tanda-tangan-container">
    <div class="section-box">
        <div class="header">
            <div class="header-strip"></div>
            <h2 class="header-title">Tanda Tangan dan Persetujuan</h2>
        </div>

        <div class="tanda-tangan-box">
            {{-- Asesi --}}
            <div class="kotak-asesi">
                <h2 class="kotak-title">Asesi</h2>

                <div class="form-group">
                    <label for="nama_asesi">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_asesi"
                        value="{{ Auth::user()->name ?? 'Nama Asesi' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" name="tanggal"
                        value="{{ now()->format('d/m/Y') }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tanda_tangan">Tanda Tangan</label>
                    <canvas id="signature-pad-asesi" class="signature-pad"></canvas>
                    <button type="button" id="clear-signature-asesi" class="btn-clear">Bersihkan</button>
                    <input type="hidden" name="tanda_tangan_asesi" id="signature-data-asesi">
                </div>
            </div>

            {{-- Asesor --}}
            <div class="kotak-asesor">
                <h2 class="kotak-title">Asesor</h2>

                <div class="form-group">
                    <label for="nama_asesor">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_asesor"
                        value="{{ Auth::user()->name ?? 'Nama Asesor' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="text" class="form-control" name="tanggal"
                        value="{{ now()->format('d/m/Y') }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tanda_tangan">Tanda Tangan</label>
                    <canvas id="signature-pad-asesor" class="signature-pad"></canvas>
                    <button type="button" id="clear-signature-asesor" class="btn-clear">Bersihkan</button>
                    <input type="hidden" name="tanda_tangan_asesor" id="signature-data-asesor">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="button-group">
    <form action="{{ route('unduh.fria05c') }}" method="POST" id="downloadForm">
    @csrf
    <input type="hidden" name="jawaban" id="jawaban-input">
    <input type="hidden" name="tanda_tangan_asesi" id="signature-data-asesi">
    <input type="hidden" name="tanda_tangan_asesor" id="signature-data-asesor">
    <button type="button" id="btn-download" class="btn-unduh">Unduh</button>
    </form>
    <button type="submit" class="btn-submit">Submit</button>
</div>

<!-- ✅ Library tanda tangan -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // isi tabel jawaban
    let jawabanData = JSON.parse(localStorage.getItem("jawaban")) || [
        { jawaban: "A" },
        { jawaban: "C" },
        { jawaban: "B" },
        { jawaban: "D" },
        { jawaban: "A" }
    ];

    let tbody = document.getElementById("jawabanTableBody");
    tbody.innerHTML = "";

    jawabanData.forEach((item, i) => {
        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${i + 1}</td>
            <td>${item.jawaban || "-"}</td>
            <td></td>
            <td></td>
        `;
        tbody.appendChild(tr);
    });

    // tanda tangan Asesi
    const canvasAsesi = document.getElementById('signature-pad-asesi');
    const signaturePadAsesi = new SignaturePad(canvasAsesi);

    document.getElementById('clear-signature-asesi').addEventListener('click', () => {
        signaturePadAsesi.clear();
    });

    // tanda tangan Asesor
    const canvasAsesor = document.getElementById('signature-pad-asesor');
    const signaturePadAsesor = new SignaturePad(canvasAsesor);

    document.getElementById('clear-signature-asesor').addEventListener('click', () => {
        signaturePadAsesor.clear();
    });

    // Simpan data tanda tangan
    document.querySelector('.btn-submit').addEventListener('click', function (e) {
        if (!signaturePadAsesi.isEmpty()) {
            document.getElementById('signature-data-asesi').value = signaturePadAsesi.toDataURL();
        } else {
            alert("Silakan tanda tangan Asesi dulu.");
            e.preventDefault();
            return;
        }

        if (!signaturePadAsesor.isEmpty()) {
            document.getElementById('signature-data-asesor').value = signaturePadAsesor.toDataURL();
        } else {
            alert("Silakan tanda tangan Asesor dulu.");
            e.preventDefault();
        }
    });

    const btnDownload = document.getElementById('btn-download');
const jawabanInput = document.getElementById('jawaban-input');
const sigInputAsesi = document.getElementById('signature-data-asesi');
const sigInputAsesor = document.getElementById('signature-data-asesor');
const downloadForm = document.getElementById('downloadForm');

btnDownload.addEventListener('click', () => {
    jawabanInput.value = localStorage.getItem('jawaban') || '[]';
    sigInputAsesi.value = signaturePadAsesi.toDataURL();
    sigInputAsesor.value = signaturePadAsesor.toDataURL();

    downloadForm.submit(); // POST ke route unduh-pdf
});
});
</script>
@endsection
