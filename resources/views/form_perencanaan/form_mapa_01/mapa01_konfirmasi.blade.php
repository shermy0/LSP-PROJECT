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
    @php
        // mapping label supaya gampang dipakai
        $roleLabels = [
            'manajer_lsp' => 'Manajer Sertifikasi LSP',
            'master_asesor' => 'Master Asesor / Lead Asesor',
            'manajer_pelatihan' => 'Manajer Pelatihan',
            'supervisor' => 'Supervisor di Tempat Kerja',
        ];
    @endphp

    @foreach ($roleLabels as $role => $label)
        @php
            // cek apakah di halaman sebelumnya role ini dipilih
            $field = 'konfirmasi_'.$role;
        @endphp

        @if ($konfirmasi && $konfirmasi->$field) 
            <tr>
                <td>{{ $label }}</td>
                <td>
                    <select name="asesor[{{ $role }}]" class="form-select">
                        <option value="">-- Pilih Asesor --</option>
                        @foreach($asesors as $asesor)
                            <option value="{{ $asesor->id_asesor }}"
                                {{ isset($roles[$role]) && $roles[$role]->id_asesor == $asesor->id_asesor ? 'selected' : '' }}>
                                {{ $asesor->nama_asesor }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="date" name="tanggal[{{ $role }}]" class="form-control"
                           value="{{ $roles[$role]->tanggal ?? '' }}">
                </td>
                <td class="text-center">
                    @if(!empty($roles[$role]->tanda_tangan))
                        <img src="{{ $roles[$role]->tanda_tangan }}" width="120"><br>
                        <a href="{{ route('form.mapa01.konfirmasi.ttd.download', $roles[$role]->id) }}" class="btn btn-sm btn-primary mt-1">Download</a>
                        <form action="{{ route('form.mapa01.konfirmasi.ttd.delete', $roles[$role]->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger mt-1">Hapus</button>
                        </form>
                    @else
                        <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                        <input type="hidden" name="tanda_tangan[{{ $role }}]" class="tanda_tangan">
                    @endif
                </td>
            </tr>
        @endif
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
                            <th>Nama</th>
                            <th>No Met</th>
                            <th>Tanggal</th>
                            <th>Tanda Tangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(DB::table('penyusun_persetujuan')->where('id_skema',$skema->id_skema)->where('role','penyusun')->get() as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->no_met }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                @if($item->tanda_tangan)
                                    <img src="{{ $item->tanda_tangan }}" width="120"><br>
                                    <a href="{{ route('form.mapa01.konfirmasi.ttd.download', $item->id) }}" class="btn btn-sm btn-primary mt-1">Download</a>
                                    <form action="{{ route('form.mapa01.konfirmasi.ttd.delete', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger mt-1">Hapus</button>
                                    </form>
                                @else
                                    <em>Belum ada tanda tangan</em>
                                @endif
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
                        </tr>
                        @endforeach

                        <tr>
                            <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penyusun"></td>
                            <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                            <td><input type="date" name="tanggal[]" class="form-control"></td>
                            <td>
                                <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
                        </tr>
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
        document.querySelector("#penyusun-table tbody").insertAdjacentHTML("beforeend", `
            <tr>
                <td><input type="text" name="nama[]" class="form-control"></td>
                <td><input type="text" name="nomet[]" class="form-control"></td>
                <td><input type="date" name="tanggal[]" class="form-control"></td>
                <td>
                    <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                    <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                </td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
            </tr>`);
    };

    document.addEventListener("click", e => {
        if (e.target.closest(".delete-row")) e.target.closest("tr").remove();
    });
});
</script>
@endsection
