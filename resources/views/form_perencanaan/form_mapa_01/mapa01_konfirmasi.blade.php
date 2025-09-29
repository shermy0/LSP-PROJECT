@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01', $skema->id_skema) }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.modifikasi', $skema->id_skema) }}">Persyaratan</a></li>
            <li class="breadcrumb-item active">Konfirmasi</li>
        </ol>
    </nav>
</div>

<form action="{{ route('form.mapa01.konfirmasi.simpan', $skema->id_skema) }}" method="POST">
    @csrf

    {{-- Orang yang Relevan --}}
    <div class="container mt-4">
        <div class="card-box">
            <div class="judul-header">Konfirmasi Dengan Orang Yang Relevan</div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered custom-table">
                    <thead class="table-title">
                        <tr>
                            <th>Orang yang relevan</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Tanda Tangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($activeRoles as $role => $info)
                        <tr>
                            <td>{{ $info['label'] }}</td>
                            <td>
                                <select name="asesor[{{ $role }}]" class="form-select">
                                    <option value="">-- Pilih Asesor --</option>
                                    @foreach($asesors as $asesor)
                                        <option value="{{ $asesor->id_asesor }}"
                                            {{ isset($info['data']) && $info['data']->id_asesor == $asesor->id_asesor ? 'selected' : '' }}>
                                            {{ $asesor->nama_asesor }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="date" name="tanggal[{{ $role }}]" class="form-control"
                                       value="{{ $info['data']->tanggal ?? '' }}">
                            </td>
                            <td class="text-center">
                                @if(!empty($info['data']->tanda_tangan))
                                    <img src="{{ $info['data']->tanda_tangan }}" width="120"><br>
                                    <a href="{{ route('form.mapa01.konfirmasi.ttd.download', $info['data']->id) }}" class="btn btn-sm btn-primary mt-1">Download</a>
                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-ttd" data-id="{{ $info['data']->id }}">Hapus</button>
                                @else
                                    <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                    <input type="hidden" name="tanda_tangan[{{ $role }}]" class="tanda_tangan">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Penyusun --}}
    <div class="container mt-4">
        <div class="card-box">
            <div class="judul-header">Penyusun</div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered custom-table" id="penyusun-table">
                    <thead class="table-title">
                        <tr>
                            <th>Nama Asesor</th>
                            <th>No Met</th>
                            <th>Tanggal</th>
                            <th>Tanda Tangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($penyusun as $i => $item)
                        <tr>
                            <td>
                                <select name="nama_asesor[{{ $i }}]" class="form-select asesor-select">
                                    <option value="">-- Pilih Asesor --</option>
                                    @foreach($asesors as $asesor)
                                        <option value="{{ $asesor->id_asesor }}"
                                            data-nomet="{{ $asesor->no_met ?? '' }}"
                                            {{ $item->id_asesor == $asesor->id_asesor ? 'selected' : '' }}>
                                            {{ $asesor->nama_asesor }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="nomet[{{ $i }}]" class="form-control nomet-input" readonly
                                    value="{{ $item->no_met ?? ($asesors->firstWhere('id_asesor', $item->id_asesor)->no_met ?? '') }}">
                            </td>
                            <td>
                                <input type="date" name="tanggal[{{ $i }}]" class="form-control" value="{{ $item->tanggal ?? '' }}">
                            </td>
                            <td class="text-center">
                                @if($item->tanda_tangan)
                                    <img src="{{ $item->tanda_tangan }}" width="120"><br>
                                    <a href="{{ route('form.mapa01.konfirmasi.ttd.download', $item->id) }}" class="btn btn-sm btn-primary mt-1">Download</a>
                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-ttd" data-id="{{ $item->id }}">Hapus</button>
                                @else
                                    <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                    <input type="hidden" name="tanda_tangan[{{ $i }}]" class="tanda_tangan">
                                @endif
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="button" id="add-row" class="btn btn-success mt-2">+ Tambah Penyusun</button>
            </div>
        </div>
    </div>

    {{-- Validator --}}
    <div class="container mt-4">
        <div class="card-box">
            <div class="judul-header">Validator</div>
            <table class="table table-bordered custom-table">
                <tr>
                    <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Validator"></td>
                    <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                    <td><input type="date" name="tanggal[]" class="form-control"></td>
                    <td>
                        <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                        <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
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
<script>
document.addEventListener("DOMContentLoaded", () => {
    const canvasModal = document.getElementById("signature-pad");
    let signaturePad = new SignaturePad(canvasModal);
    let activePreview;

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // Buka modal ketika klik preview
    document.addEventListener("click", e => {
        if (e.target.classList.contains("signature-preview")) {
            activePreview = e.target;
            const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
            modal.show();
            document.getElementById('signatureModal').addEventListener('shown.bs.modal', resizeCanvas, { once: true });
        }
    });

    document.getElementById("clear-signature").onclick = () => signaturePad.clear();

    document.getElementById("save-signature").onclick = () => {
        if (!signaturePad.isEmpty() && activePreview) {
            const dataURL = signaturePad.toDataURL();
            const ctx = activePreview.getContext("2d");
            const img = new Image();
            img.onload = () => {
                ctx.clearRect(0, 0, activePreview.width, activePreview.height);
                ctx.drawImage(img, 0, 0, activePreview.width, activePreview.height);
            }
            img.src = dataURL;
            activePreview.nextElementSibling.value = dataURL;
        }
    };

    // Tambah baris penyusun
    document.getElementById("add-row").onclick = () => {
        const i = document.querySelectorAll("#penyusun-table tbody tr").length;
        const options = `@foreach($asesors as $asesor)<option value="{{ $asesor->id_asesor }}" data-nomet="{{ $asesor->no_met ?? '' }}">{{ $asesor->nama_asesor }}</option>@endforeach`;
        document.querySelector("#penyusun-table tbody").insertAdjacentHTML("beforeend", `
            <tr>
                <td>
                    <select name="nama_asesor[${i}]" class="form-select asesor-select">
                        <option value="">-- Pilih Asesor --</option>
                        ${options}
                    </select>
                </td>
                <td><input type="text" name="nomet[${i}]" class="form-control nomet-input" readonly></td>
                <td><input type="date" name="tanggal[${i}]" class="form-control"></td>
                <td>
                    <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                    <input type="hidden" name="tanda_tangan[${i}]" class="tanda_tangan">
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
            </tr>
        `);
    };

    // Hapus row penyusun baru
    document.addEventListener("click", e => {
        if (e.target.closest(".delete-row")) e.target.closest("tr").remove();
    });

    // Update No Met otomatis saat pilih asesor
    document.addEventListener("change", e => {
        if (e.target.classList.contains("asesor-select")) {
            const selected = e.target.selectedOptions[0];
            const noMet = selected.dataset.nomet || '';
            const row = e.target.closest("tr");
            const nometInput = row.querySelector(".nomet-input");
            if (nometInput) nometInput.value = noMet;
        }
    });

    // ==== AJAX Hapus TTD ====
    document.addEventListener("click", e => {
        if(e.target.classList.contains('delete-ttd')) {
            const btn = e.target;
            const id = btn.dataset.id;
            if(confirm('Yakin ingin menghapus tanda tangan?')) {
                fetch(`{{ url('form-perencanaan/mapa01/konfirmasi/ttd') }}/${id}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const td = btn.closest('td');
                        td.innerHTML = `<canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                        <input type="hidden" name="tanda_tangan[${id}]" class="tanda_tangan">`;
                        alert(data.message);
                    } else {
                        alert(data.message || 'Gagal menghapus tanda tangan.');
                    }
                })
                .catch(() => alert('Gagal menghapus tanda tangan.'));
            }
        }
    });
});
</script>
@endsection
