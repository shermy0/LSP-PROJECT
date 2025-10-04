@extends('master')

@section('konten')
<div class="card-box">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form_perencanaan.fr_va', ['periode' => $periode]) }}">FR.VA {{ $periode }}</a></li>
        </ol>
    </nav>

    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.VA – MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>
    </div>

    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>

    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">PERIODE:</span>
            <span class="text-primary fw-bold">{{ $periodeText }}</span>
        </div>
    </div>

    <form action="{{ route('form_perencanaan.fr_va_asesor.simpan') }}" method="POST">
        @csrf
        <input type="hidden" name="skema_id" value="{{ $skema_id }}">
        <input type="hidden" name="periode" value="{{ $periode }}">

        <!-- Form Asesmen -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                    <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tempat</label>
                <input type="text" class="form-control" value="SMKN 11 BANDUNG - Mandiri" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" name="tanggalAsesmen" value="{{ date('Y-m-d') }}">
            </div>
        </div>

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
                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Bagian dari Proses Penjaminan Mutu Organisasi"> Bagian dari Proses Penjaminan Mutu Organisasi</td>
                            <td><input type="checkbox" name="konteks[]" value="Internal Organisasi"> Internal Organisasi</td>
                            <td><input type="checkbox" name="pendekatan[]" value="Internal Organisasi"> Internal Organisasi</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Mengantisipasi Risiko"> Mengantisipasi Risiko</td>
                            <td><input type="checkbox" name="konteks[]" value="Eksternal Organisasi"> Eksternal Organisasi</td>
                            <td><input type="checkbox" name="pendekatan[]" value="Pertemuan Moderasi"> Pertemuan Moderasi</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Memenuhi Persyaratan BNSP"> Memenuhi Persyaratan BNSP</td>
                            <td><input type="checkbox" name="konteks[]" value="Proses Lisensi / Re-Lisensi"> Proses Lisensi / Re-Lisensi</td>
                            <td><input type="checkbox" name="pendekatan[]" value="Mengkaji Perangkat Asesmen"> Mengkaji Perangkat Asesmen</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Memastikan Kesesuaian Bukti"> Memastikan Kesesuaian Bukti</td>
                            <td><input type="checkbox" name="konteks[]" value="Dengan Kolega Asesor"> Dengan Kolega Asesor</td>
                            <td><input type="checkbox" name="pendekatan[]" value="Acuan Pembanding"> Acuan Pembanding</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Meningkatkan Kualitas Asesmen"> Meningkatkan Kualitas Asesmen</td>
                            <td><input type="checkbox" name="konteks[]" value="Kolega dari Organisasi Pelatihan atau Asesmen"> Kolega dari Organisasi Pelatihan atau Asesmen</td>
                            <td><input type="checkbox" name="pendekatan[]" value="Pengujian lapangan dan uji coba perangkat asesmen"> Pengujian lapangan dan uji coba perangkat asesmen</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="Mengevaluasi Kualitas Perangkat Asesmen"> Mengevaluasi Kualitas Perangkat Asesmen</td>
                            <td>
                                <input type="checkbox" id="konteksLainCheck"> 
                                <input type="text" class="form-control" name="konteks_lain" placeholder="Masukkan Konteks lain" disabled>
                            </td>
                            <td><input type="checkbox" name="pendekatan[]" value="Umpan Balik dari Klien"> Umpan Balik dari Klien</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="tujuanLainCheck"> 
                                <input type="text" class="form-control" name="tujuan_lain" placeholder="Masukkan Tujuan lain" disabled>
                            </td>
                            <td>
                                <input type="checkbox" id="konteksLain2Check"> 
                                <input type="text" class="form-control" name="konteks_lain2" placeholder="Masukkan Konteks lain" disabled>
                            </td>
                            <td><input type="checkbox" name="pendekatan[]" value="Mengkaji Bukti-bukti"> Mengkaji Bukti-bukti</td>
                        </tr>
                    </tbody>
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
                        <input class="form-check-input toggle-section" type="checkbox" id="{{ $id }}" name="orangRelevan[]" value="{{ $id }}" data-target="{{ $id }}Form">
                        <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
                    </div>
                    <div id="{{ $id }}Form" class="mt-2" style="display:none;"></div>
                </div>
            @endforeach
        </div>

        <!-- 2. Acuan Pembanding & Dokumen -->
        <div class="card-box mb-4">
            <div class="judul-box"><div class="judul-header">2. Acuan Pembanding & Dokumen</div></div>
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
                            <td><input type="checkbox" name="acuan[]" value="Standar Kompetensi (SKKNI/SKKK/SKI)"> Standar Kompetensi (SKKNI/SKKK/SKI)</td>
                            <td><input type="checkbox" name="dokumen[]" value="Perangkat Asesmen"> Perangkat Asesmen</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="acuan[]" value="Skema Sertifikasi"> Skema Sertifikasi</td>
                            <td><input type="checkbox" name="dokumen[]" value="Peraturan / Pedoman"> Peraturan / Pedoman</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="acuan[]" value="SOP/IK"> SOP/IK</td>
                            <td><input type="checkbox" name="dokumen[]" value="Bukti-bukti hasil asesmen"> Bukti-bukti hasil asesmen</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="acuan[]" value="Manual Instruction / Book Manual"> Manual Instruction / Book Manual</td>
                            <td>
                                <input type="checkbox" id="dokumenLain1Check"> 
                                <input type="text" class="form-control" id="dokumenLain1Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="acuan[]" value="Standar Kinerja"> Standar Kinerja</td>
                            <td>
                                <input type="checkbox" id="dokumenLain2Check"> 
                                <input type="text" class="form-control" id="dokumenLain2Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="simpan-btn"><span>Simpan dan Lanjut</span></button>
    </form>
</div>

<!-- JS Toggle -->
<script>
document.addEventListener("DOMContentLoaded", function(){
    // Toggle input lain
    function toggleInput(checkId, inputSelector){
        const check = document.getElementById(checkId);
        const input = document.querySelector(inputSelector);
        if(check && input){
            check.addEventListener("change", function(){
                input.disabled = !this.checked;
                if(!this.checked) input.value = "";
            });
        }
    }
    toggleInput("tujuanLainCheck", "input[name='tujuan_lain']");
    toggleInput("konteksLainCheck", "input[name='konteks_lain']");
    toggleInput("konteksLain2Check", "input[name='konteks_lain2']");
    toggleInput("dokumenLain1Check", "#dokumenLain1Input");
    toggleInput("dokumenLain2Check", "#dokumenLain2Input");

    // Toggle orang relevan
    document.querySelectorAll(".toggle-section").forEach(checkbox=>{
        checkbox.addEventListener("change", function(){
            const target = document.getElementById(this.dataset.target);
            if(this.checked){
                target.innerHTML = `
                <div class="input-group mb-2">
                    <input type="text" name="${this.id}_nama[]" class="form-control" placeholder="Nama Asesor">
                    <input type="text" name="${this.id}_diskusi[]" class="form-control" placeholder="Hasil Diskusi">
                    <button class="btn btn-danger removeNama" type="button">Hapus</button>
                </div>
                <button type="button" class="btn btn-success btn-sm addNama" data-target="${this.id}-namaList">+ Tambah</button>`;
                target.style.display = "block";

                target.addEventListener("click", function(e){
                    if(e.target.classList.contains("addNama")){
                        const list = target.querySelector(".input-group").parentNode;
                        const div = document.createElement("div");
                        div.classList.add("input-group","mb-2");
                        div.innerHTML = `
                            <input type="text" name="${checkbox.id}_nama[]" class="form-control" placeholder="Nama Asesor">
                            <input type="text" name="${checkbox.id}_diskusi[]" class="form-control" placeholder="Hasil Diskusi">
                            <button class="btn btn-danger removeNama" type="button">Hapus</button>`;
                        list.appendChild(div);
                    }
                    if(e.target.classList.contains("removeNama")){
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
@endsection
