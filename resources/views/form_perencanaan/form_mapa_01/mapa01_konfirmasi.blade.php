@extends('master')

@section('konten')
        <div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01') }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('form.mapa01.modifikasi', $skema->id_skema) }}">Mengidentifikasi Persyaratan</a></li>

            <li class="breadcrumb-item active" aria-current="page">Konfirmasi</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="card-box">
        <div class="judul-header">Konfirmasi Dengan Orang Yang Relevan</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">Orang yang relevan</th>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                    </tr>
                </thead>
<tbody>
    @foreach($roles as $role)
        <tr>
            <td>{{ $role }}</td>
            <td>
                <select name="asesor[{{ $role }}]" class="form-select">
                    <option value="">-- Pilih Nama --</option>
                    @foreach($asesors as $asesor)
                        <option value="{{ $asesor->id_asesor }}">
                            {{ $asesor->nama_asesor }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="date" name="tanggal[{{ $role }}]" class="form-control"></td>
            <td class="text-center">
                <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                <input type="hidden" name="tanda_tangan[{{ $role }}]" class="tanda_tangan">
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
</div>

<div class="container mt-4">
    <!-- Penyusun -->
    <div class="card-box">
        <div class="judul-header">Penyusun</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="penyusun-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">No Met</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penyusun"></td>
                        <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
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
            <button type="button" id="add-row" class="btn btn-success mt-2">+ Tambah Data Penyusun</button>
        </div>
    </div>
</div>

<!-- Modal tanda tangan -->
<div class="modal fade" id="signatureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tanda Tangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <canvas id="signature-pad" style="border:1px solid #ccc; width:100%; height:300px;"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" id="clear-signature" class="btn btn-danger">Hapus</button>
        <button type="button" id="save-signature" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
    <!-- Penyusun -->
    <div class="card-box">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="penyusun-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">No Met</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Validator"></td>
                        <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal tanda tangan -->
<div class="modal fade" id="signatureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tanda Tangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <canvas id="signature-pad" style="border:1px solid #ccc; width:100%; height:300px;"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" id="clear-signature" class="btn btn-danger">Hapus</button>
        <button type="button" id="save-signature" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-form" 
      action="{{ route('form.mapa01.konfirmasi.simpan', $skema->id_skema) }}" 
      method="POST" 
      class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>



<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>

    $(function(){
    $(".asesor-autocomplete").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('asesor.search') }}",
                data: {
                    q: request.term,
                    skema_id: "{{ $skema->id_skema }}"
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nama_asesor + " (" + item.jabatan + ")",
                            value: item.nama_asesor,
                            id: item.id_asesor
                        };
                    }));
                }
            });
        },
        minLength: 2
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#penyusun-table tbody");
    const addRowBtn = document.getElementById("add-row");
    const canvasModal = document.getElementById("signature-pad");
    let signaturePad = new SignaturePad(canvasModal);
    let activePreview;

    // Tambah baris baru
    addRowBtn.addEventListener("click", function () {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penyusun"></td>
            <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
            <td><input type="date" name="tanggal[]" class="form-control"></td>
            <td class="text-center">
                <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });

    // Hapus baris
    document.addEventListener("click", function(e) {
        if (e.target.closest(".delete-row")) {
            e.target.closest("tr").remove();
        }
    });

    // Resize canvas modal (fix biar gak blank)
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // Klik canvas kecil -> buka modal
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("signature-preview")) {
            activePreview = e.target;
            const modalEl = document.getElementById('signatureModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            // resize saat modal ditampilkan
            modalEl.addEventListener('shown.bs.modal', resizeCanvas, { once: true });
        }
    });

    // Tombol hapus tanda tangan
    document.getElementById("clear-signature").addEventListener("click", function () {
        signaturePad.clear();
    });

    // Tombol simpan tanda tangan
    document.getElementById("save-signature").addEventListener("click", function () {
        if (!signaturePad.isEmpty() && activePreview) {
            const dataURL = signaturePad.toDataURL();
            const ctx = activePreview.getContext("2d");
            const img = new Image();
            img.onload = function() {
                ctx.clearRect(0, 0, activePreview.width, activePreview.height);
                ctx.drawImage(img, 0, 0, activePreview.width, activePreview.height);
            }
            img.src = dataURL;
            activePreview.nextElementSibling.value = dataURL;
        }
    });
});
</script>
@endsection