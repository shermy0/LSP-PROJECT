@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('form_perencanaan.fr_va', ['periode' => $periode, 'skema_id' => $skema_id ?? '']) }}">
                    FR.VA {{ $periodeText }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Memberikan Kontribusi dan Rencana Perbaikan
            </li>
        </ol>
    </nav>
</div>

@php
use App\Models\Skema;
use Illuminate\Support\Facades\DB;

$skema = $skema_id ? Skema::find($skema_id) : null;

// Ambil daftar asesor sesuai skema
$asesors = DB::table('asesor')
    ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
    ->where('asesor_skema.skema_id', $skema_id)
    ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi')
    ->get();

// Validator
$validators = $asesors;
@endphp

<form action="{{ route('formperencanaan.simpan_semua') }}" method="POST">
    @csrf
    <input type="hidden" name="skema_id" value="{{ $skema_id }}">
    <input type="hidden" name="periode" value="{{ $periode }}">

    {{-- 1. Memberikan Kontribusi --}}
    <div class="card-box mt-4">
        <div class="judul-header">3. Memberikan Kontribusi untuk Hasil Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="kontribusi-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Temuan Validasi</th>
                        <th class="text-center">Rekomendasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center no">1</td>
                        <td><input type="text" name="temuan[]" class="form-control"></td>
                        <td><input type="text" name="rekomendasi[]" class="form-control"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="add-kontribusi-row" class="btn btn-success mt-2">+ Tambah</button>
        </div>
    </div>

    {{-- 2. Rencana Perbaikan --}}
    <div class="card-box mt-4">
        <div class="judul-header">Rencana Implementasi Perubahan / Perbaikan Pelaksanaan Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="perbaikan-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center no">No</th>
                        <th class="text-center">Kegiatan perbaikan sesuai rekomendasi</th>
                        <th class="text-center">Waktu Penyelesaian</th>
                        <th class="text-center">Penanggung Jawab</th>
                        <th class="text-center">Tanda Tangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center no">1</td>
                        <td><input type="text" name="perbaikan[]" class="form-control" placeholder="Isi perbaikan"></td>
                        <td><input type="date" name="waktu[]" class="form-control"></td>
                        <td>
                            <select name="penanggung[]" class="form-control penanggung">
                                <option value="">-- Pilih Penanggung Jawab --</option>
                                @foreach($asesors as $asesor)
                                    <option value="{{ $asesor->nama_asesor }}" data-no="{{ $asesor->no_registrasi }}">{{ $asesor->nama_asesor }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="no_registrasi_penanggung[]" class="no-registrasi-penanggung">
                        </td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2 add-row" id="add-perbaikan-row">+ Tambah Data</button>
        </div>
    </div>

    {{-- 3. Validator --}}
    <div class="card-box mt-4">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="validator-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Nama Validator</th>
                        <th class="text-center">No Met</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Tanda Tangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="nama_validator[]" class="form-control nama-validator">
                                <option value="">-- Pilih Validator --</option>
                                @foreach($validators as $validator)
                                    <option value="{{ $validator->nama_asesor }}" data-no="{{ $validator->no_registrasi }}">{{ $validator->nama_asesor }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" name="no_registrasi[]" class="form-control no-registrasi" readonly></td>
                        <td><input type="date" name="tanggal_validator[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan_validator[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2" id="add-validator-row">+ Tambah Validator</button>
        </div>
    </div>

    <button type="submit" class="simpan-btn mt-4"><span>Simpan</span></button>
</form>

{{-- Modal Tanda Tangan --}}
<div class="modal fade" id="signatureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Tanda Tangan</h5></div>
      <div class="modal-body">
        <canvas id="signature-pad" style="border:1px solid #ccc;width:100%;height:300px;"></canvas>
      </div>
      <div class="modal-footer">
        <button id="clear-signature" class="btn btn-warning">Clear</button>
        <button id="save-signature" class="btn btn-success" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateNo(table) {
        Array.from(table.querySelectorAll('tr')).forEach((row,i)=>{
            const noCell = row.querySelector('.no');
            if(noCell) noCell.textContent = i+1;
        });
    }

    ['kontribusi','perbaikan','validator'].forEach(id=>{
        const tbody = document.getElementById(id+'-table').querySelector('tbody');
        document.getElementById('add-'+id+'-row')?.addEventListener('click', ()=>{
            const clone = tbody.querySelector('tr').cloneNode(true);
            clone.querySelectorAll('input').forEach(i=>i.value='');
            clone.querySelectorAll('select').forEach(s=>s.selectedIndex=0);
            clone.querySelectorAll('canvas').forEach(c=>c.getContext('2d').clearRect(0,0,c.width,c.height));
            tbody.appendChild(clone);
            updateNo(tbody);
        });
        tbody.addEventListener('click', e=>{
            if(e.target.closest('.delete-row')) { e.target.closest('tr').remove(); updateNo(tbody); }
        });
        updateNo(tbody);
    });

    document.addEventListener('change', e=>{
        if(e.target.classList.contains('penanggung')){
            const no = e.target.selectedOptions[0]?.dataset.no || '';
            e.target.closest('tr').querySelector('.no-registrasi-penanggung').value=no;
        }
        if(e.target.classList.contains('nama-validator')){
            const no = e.target.selectedOptions[0]?.dataset.no || '';
            e.target.closest('tr').querySelector('.no-registrasi').value=no;
        }
    });

    const canvasModal = document.getElementById("signature-pad");
    const signaturePad = new SignaturePad(canvasModal);
    let activeInput;

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    document.addEventListener("click", e => {
        if(e.target.classList.contains("signature-preview")){
            activeInput = e.target.closest('td').querySelector('.tanda_tangan');
            const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
            modal.show();
            document.getElementById('signatureModal').addEventListener('shown.bs.modal', resizeCanvas, { once: true });
            if(activeInput.value) signaturePad.fromDataURL(activeInput.value);
        }
    });

    document.getElementById("clear-signature").onclick = () => signaturePad.clear();

    document.getElementById("save-signature").onclick = () => {
        if(activeInput && !signaturePad.isEmpty()){
            const dataURL = signaturePad.toDataURL();
            const preview = activeInput.closest('td').querySelector('.signature-preview');
            const ctx = preview.getContext('2d');
            const img = new Image();
            img.onload = () => { ctx.clearRect(0,0,preview.width,preview.height); ctx.drawImage(img,0,0,preview.width,preview.height); };
            img.src = dataURL;
            activeInput.value = dataURL;
        }
    };
});
</script>
@endsection
