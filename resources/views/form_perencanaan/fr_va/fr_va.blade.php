@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form_perencanaan.fr_va', ['periode' => $periode]) }}">FR.VA {{ $periode }}</a></li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.VA – MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>
    </div>

    <!-- Skema -->
    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
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
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                    <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="tempat" class="form-label">Tempat</label>
                <input type="text" class="form-control" id="tempat" 
                    name="tempat" 
                    value="SMKN 11 BANDUNG - Mandiri" 
                    readonly>
            </div>
            <div class="col-md-4">
                <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen" name="tanggalAsesmen"
                    value="{{ date('Y-m-d') }}">
            </div>
        </div>
    </form>
</div>

<form id="simpan-form" action="{{ route('form_perencanaan.fr_va_asesor.simpan') }}" method="POST" class="simpan-form">
    @csrf
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
                <input 
                    class="form-check-input toggle-section" 
                    type="checkbox" 
                    id="{{ $id }}" 
                    name="orangRelevan[]" 
                    value="{{ $id }}"
                    data-target="{{ $id }}Form"
                >
                <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
            </div>

            <!-- Form tambahan kalau diceklis -->
            <div id="{{ $id }}Form" class="mt-2" style="display:none;">
                <input type="text" class="form-control" name="{{ $id }}_nama" placeholder="Masukkan nama">
                <input type="text" class="form-control mt-2" name="{{ $id }}_hasil" placeholder="Masukkan hasil">
            </div>
        </div>
    @endforeach
</div>
<script>
$(document).ready(function() {
    $('.toggle-section').each(function() {
        var target = $(this).data('target');
        var div = $('#' + target);

        // cek jika awalnya dicentang
        if ($(this).is(':checked')) {
            div.show();
        }

        $(this).change(function() {
            if ($(this).is(':checked')) {
                div.show();
            } else {
                div.hide();
                // optional: bersihkan input yang di-hide
                div.find('input').val('');
            }
        });
    });
});
</script>


<input type="hidden" name="id_validasi" value="{{ $id_validasi ?? '' }}">
<input type="hidden" name="skema_id" value="{{ $skema_id }}">

        <!-- 2. Acuan Pembanding & Dokumen -->
<div class="card-box mb-4">
    <div class="judul-box">
        <div class="judul-header">2. Acuan Pembanding & Dokumen</div>
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
                    <td>
                        <input type="checkbox" name="acuan[]" value="Manual Instruction / Book Manual"> Manual Instruction / Book Manual
                    </td>
                    <td>
                        <input type="checkbox" id="dokumenLain1Check"> 
                        <input type="text" class="form-control" id="dokumenLain1Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="acuan[]" value="Standar Kinerja"> Standar Kinerja
                    </td>
                    <td>
                        <input type="checkbox" id="dokumenLain2Check"> 
                        <input type="text" class="form-control" id="dokumenLain2Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('dokumenLain1Check').addEventListener('change', function() {
        document.getElementById('dokumenLain1Input').disabled = !this.checked;
    });

    document.getElementById('dokumenLain2Check').addEventListener('change', function() {
        document.getElementById('dokumenLain2Input').disabled = !this.checked;
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    function toggleInput(checkboxId, inputId){
        const check = document.getElementById(checkboxId);
        const input = document.getElementById(inputId);
        if(check && input){
            check.addEventListener("change", function(){
                input.disabled = !this.checked;
                if(!this.checked){ input.value = ""; }
            });
        }
    }
    toggleInput("dokumenLain1Check","dokumenLain1Input");
    toggleInput("dokumenLain2Check","dokumenLain2Input");
});
</script>

    <!-- 2. Memberikan Kontribusi dalam Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box"><div class="judul-header">Memberikan Kontribusi dalam Proses Validasi</div></div>
        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Keterampilan Komunikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Keterampilan komunikasi yang digunakan dalam kegiatan validasi :</td>
                        <td>
                            @php $skills = ['Pro Aktif','Active Listening','Empati']; @endphp
                            @foreach($skills as $skill)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                        id="skill_{{ $loop->index }}" 
                                        name="keterampilan[]" 
                                        value="{{ $skill }}">
                                    <label class="form-check-label" for="skill_{{ $loop->index }}">{{ $skill }}</label>
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
        <div class="judul-header">Aspek dalam Kegiatan</div>
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

<input type="hidden" name="periode" value="{{ $periode }}">
    <button type="submit" class="simpan-btn"><span>Simpan dan Lanjut</span></button>
</form>

<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
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
});
</script>
{{-- JS Toggle --}}
<script>
document.addEventListener("DOMContentLoaded", function(){
    function toggleInput(checkboxId, inputName){
        const check = document.getElementById(checkboxId);
        const input = document.querySelector(`input[name="${inputName}"]`);
        if(check && input){
            check.addEventListener("change", function(){
                input.disabled = !this.checked;
                if(!this.checked){ input.value = ""; }
            });
        }
    }
    toggleInput("tujuanLainCheck", "tujuan_lain");
    toggleInput("konteksLainCheck", "konteks_lain");
    toggleInput("konteksLain2Check", "konteks_lain2");
    toggleInput("dokumenLain1Check", "dokumen_lain1");
    toggleInput("dokumenLain2Check", "dokumen_lain2");
});
</script>
@endsection
