@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Daftar Skema</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01', $skema->id_skema) }}">FR.MAPA.01</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.kodeunit', $skema->id_skema) }}">Rencana Asesmen</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form.mapa01.modifikasi', $skema->id_skema) }}">Persyaratan</a></li>
            <li class="breadcrumb-item active">Konfirmasi</li>
        </ol>
    </nav>
</div>

<form action="{{ route('form.mapa01.konfirmasi.simpan', $skema->id_skema) }}" method="POST" id="page-konfirmasi-marker">
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
                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-ttd"
                                            data-id="{{ $info['data']->id }}"
                                            data-role="{{ $role }}">Hapus</button>
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
                            <input type="hidden" name="penyusun_id[{{ $i }}]" value="{{ $item->id }}">
                            <input type="hidden" name="form_type[{{ $i }}]" value="mapa01">
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
                                <button type="button" class="btn btn-sm btn-danger mt-1 delete-ttd"
                                        data-id="{{ $item->id }}"
                                        data-index="{{ $i }}">Hapus</button>
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
        <div class="table-responsive mt-3">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>Nama Validator</th>
                        <th>No Registrasi</th>
                        <th>Tanggal</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($validators as $v)
                        <tr>
                            <td>{{ $v->nama_validator }}</td>
                            <td>{{ $v->no_registrasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($v->ttd)
                                    <img src="{{ $v->ttd }}" width="120" alt="TTD Validator">
                                @else
                                    <span class="text-muted">Belum ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data validator</td>
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

    function resizeCanvas() {
        let dataURL = "";
        if (activePreview && activePreview.nextElementSibling.value) {
            dataURL = activePreview.nextElementSibling.value;
        }

        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();

        if (dataURL) {
            const img = new Image();
            img.onload = () => {
                const scaleX = canvasModal.width / img.width / ratio;
                const scaleY = canvasModal.height / img.height / ratio;
                signaturePad._ctx.scale(scaleX, scaleY);
                signaturePad._ctx.drawImage(img, 0, 0);
                signaturePad._ctx.setTransform(1,0,0,1,0,0);
            };
            img.src = dataURL;
        }
    }

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

    document.getElementById("add-row").onclick = () => {
        const i = document.querySelectorAll("#penyusun-table tbody tr").length;
        const options = `@foreach($asesors as $asesor)<option value="{{ $asesor->id_asesor }}" data-nomet="{{ $asesor->no_met ?? '' }}">{{ $asesor->nama_asesor }}</option>@endforeach`;
        document.querySelector("#penyusun-table tbody").insertAdjacentHTML("beforeend", `
            <tr>
                <td>
                    <input type="hidden" name="form_type[${i}]" value="mapa01">
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

    document.addEventListener("change", e => {
        if (e.target.classList.contains("asesor-select")) {
            const selected = e.target.selectedOptions[0];
            const noMet = selected.dataset.nomet || '';
            const row = e.target.closest("tr");
            const nometInput = row.querySelector(".nomet-input");
            if (nometInput) nometInput.value = noMet;
        }
    });

    // ==== AJAX Hapus TTD dengan SweetAlert ====
    document.addEventListener("click", e => {
        if(e.target.classList.contains('delete-ttd')) {
            const btn = e.target;
            const id = btn.dataset.id;
            const role = btn.dataset.role;
            const index = btn.dataset.index;

            Swal.fire({
                title: 'Yakin ingin menghapus tanda tangan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if(result.isConfirmed){
                    fetch(`{{ url('form-perencanaan/mapa01/konfirmasi/ttd') }}/${id}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            const td = btn.closest('td');
                            let hiddenName = role ? `tanda_tangan[${role}]` : `tanda_tangan[${index}]`;
                            td.innerHTML = `<canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc;cursor:pointer;"></canvas>
                                            <input type="hidden" name="${hiddenName}" class="tanda_tangan">`;
                            Swal.fire('Berhasil', data.message, 'success');
                        } else {
                            Swal.fire('Gagal', data.message || 'Gagal menghapus tanda tangan', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Gagal', 'Gagal menghapus tanda tangan', 'error'));
                }
            });
        }
    });

    // ==== Hapus penyusun dengan SweetAlert ====
    document.addEventListener("click", e => {
        if (e.target.classList.contains("delete-row")) {
            const row = e.target.closest("tr");
            const penyusunIdInput = row.querySelector("input[name^='penyusun_id']");
            if (penyusunIdInput) {
                const penyusunId = penyusunIdInput.value;
                Swal.fire({
                    title: 'Yakin ingin menghapus penyusun ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if(result.isConfirmed){
                        fetch(`{{ url('form-perencanaan/mapa01/konfirmasi/penyusun') }}/${penyusunId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            if(res.ok){
                                row.remove();
                                Swal.fire('Berhasil', 'Penyusun berhasil dihapus', 'success');
                            } else {
                                Swal.fire('Gagal', 'Gagal menghapus penyusun', 'error');
                            }
                        })
                        .catch(() => Swal.fire('Gagal', 'Gagal menghapus penyusun', 'error'));
                    }
                });
            } else {
                row.remove(); // hapus langsung jika row baru
            }
        }
    });

    // ==== Notifikasi berhasil simpan ====
    @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Tetap di Halaman",
            cancelButtonText: "Ke Form Perencanaan"
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = "{{ route('formperencanaan.show', $skema->id_skema) }}";
            }
        });
    @endif
});


</script>
@endsection
