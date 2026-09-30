@extends('master')

@section('konten')
<div class="card-box">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa02', ['id_skema' => $skema->id_skema]) }}">FR.MAPA.02</a></li>
            <li class="breadcrumb-item active" aria-current="page">Penyusun Persetujuan</li>
        </ol>
    </nav>
</div>

<form action="{{ route('form.mapa02.penyusun.store', $skema->id_skema) }}" method="POST" id="mapa02-asesor-form">
    @csrf

{{-- Penyusun MAPA.02 --}}
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
                                <input type="hidden" name="penyusun_id[{{ $i }}]" value="{{ $item->id }}">
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
                                    <a href="{{ route('form.mapa02.penyusun.downloadTtd', $item->id) }}" class="btn btn-sm btn-primary mt-1">Download</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-ttd" data-id="{{ $item->id }}">Hapus TTD</button>
                                @else
                                    <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                    <input type="hidden" name="tanda_tangan[{{ $i }}]" class="tanda_tangan">
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row" data-id="{{ $item->id }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="button" id="add-row" class="btn btn-success mt-2">+ Tambah Penyusun</button>
        </div>
    </div>
</div>

{{-- Validator (hanya info) --}}
<div class="container mt-4">
    <div class="card-box">
        <div class="judul-header d-flex justify-content-between align-items-center">
            <span>Validator</span>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>Nama Validator</th>
                        <th>No Met</th>
                        <th>Tanggal</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($validators as $v)
                        <tr>
                            <td>{{ $v->nama_validator }}</td>
                            <td>{{ $v->no_met }}</td>
                            <td>{{ \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($v->ttd)
                                    <img src="{{ $v->ttd }}" alt="TTD Validator" width="120">
                                @else
                                    <span class="text-muted">Belum ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data validator untuk skema ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


    <div class="mt-4">
        <button type="submit" class="simpan-btn">Simpan</button>
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

    // Resize canvas signature modal
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // Buka modal tanda tangan
    document.addEventListener("click", e => {
        if (e.target.classList.contains("signature-preview") && !e.target.classList.contains("validator-field")) {
            activePreview = e.target;
            const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
            modal.show();
            document.getElementById('signatureModal').addEventListener('shown.bs.modal', resizeCanvas, { once: true });
        }
    });

    // Clear signature di modal
    document.getElementById("clear-signature").onclick = () => signaturePad.clear();

    // Simpan signature ke canvas preview & hidden input
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

    // Tambah row baru
    document.getElementById("add-row").onclick = () => {
        const i = document.querySelectorAll("#penyusun-table tbody tr").length;
        const options = `@foreach($asesors as $asesor)<option value="{{ $asesor->id_asesor }}" data-nomet="{{ $asesor->no_met ?? '' }}">{{ $asesor->nama_asesor }}</option>@endforeach`;
        document.querySelector("#penyusun-table tbody").insertAdjacentHTML("beforeend", `
            <tr>
                <td><select name="nama_asesor[${i}]" class="form-select asesor-select"><option value="">-- Pilih Asesor --</option>${options}</select></td>
                <td><input type="text" name="nomet[${i}]" class="form-control nomet-input" readonly></td>
                <td><input type="date" name="tanggal[${i}]" class="form-control"></td>
                <td><canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas><input type="hidden" name="tanda_tangan[${i}]" class="tanda_tangan"></td>
                <td><button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button></td>
            </tr>
        `);
    };


    // Update No Met otomatis
    document.addEventListener("change", e => {
        if (e.target.classList.contains("asesor-select")) {
            const noMet = e.target.selectedOptions[0].dataset.nomet || '';
            e.target.closest("tr").querySelector(".nomet-input").value = noMet;
        }
    });

    // Hapus baris (baru, belum tersimpan di DB)
    document.addEventListener("click", e => {
        if (e.target.classList.contains("delete-row") && !e.target.dataset.id) {
            e.target.closest("tr").remove();
        }
    });

    // Alert untuk validator field
    document.querySelectorAll(".validator-field").forEach(field => {
        field.addEventListener("focus", showAlert);
        field.addEventListener("click", showAlert);
    });
    function showAlert(e) {
        e.preventDefault();
        Swal.fire({icon:'warning',title:'Akses Ditolak',text:'Validator diisi di FR.VA'});
        e.target.blur();
    }

    // Hapus TTD lama
    document.addEventListener("click", e => {
        if (e.target.classList.contains("delete-ttd")) {
            e.preventDefault();
            let id = e.target.dataset.id;
            Swal.fire({
                title: "Hapus Tanda Tangan?",
                text: "Tanda tangan ini akan dihapus permanen.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('form.mapa02.penyusun.deleteTtd', ':id') }}".replace(':id', id);
                    fetch(url, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Terhapus!", data.message, "success").then(() => location.reload());
                        } else {
                            Swal.fire("Gagal", data.message, "error");
                        }
                    }).catch(() => Swal.fire("Error", "Terjadi kesalahan server.", "error"));
                }
            });
        }
    });

    // Hapus row lama (sudah tersimpan)
    document.addEventListener("click", e => {
        if (e.target.classList.contains("delete-row") && e.target.dataset.id) {
            const id = e.target.dataset.id;
            Swal.fire({
                title: "Hapus Penyusun?",
                text: "Data penyusun ini akan dihapus permanen.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('form.mapa02.penyusun.delete', ':id') }}`.replace(':id', id), {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        }
                    }).then(res => res.json())
                    .then(data => {
                        if(data.success) location.reload();
                        else Swal.fire("Gagal", data.message, "error");
                    }).catch(() => Swal.fire("Error", "Terjadi kesalahan server.", "error"));
                }
            });
        }
    });


    // SweetAlert simpan
    document.getElementById("mapa02-asesor-form").addEventListener("submit", function(e){
        e.preventDefault();
        let form = this;

        // Simpan TTD terakhir ke hidden input
        if (!signaturePad.isEmpty() && activePreview) {
            activePreview.nextElementSibling.value = signaturePad.toDataURL();
        }

        Swal.fire({
            title: "Berhasil!",
            text: "Tanda tangan dan catatan berhasil disimpan.",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Tetap di Halaman",
            cancelButtonText: "Ke Form Perencanaan"
        }).then((result) => {
            form.submit(); // kirim form dulu
            if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "{{ route('formperencanaan.show', $skema->id_skema) }}";
            }
        });
    });

});
</script>
@endsection