@extends('master')

@section('konten')
<div class="container mt-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formasesmen') }}" class="text-primary">Form Asesmen</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.IA.07</li>
        </ol>
    </nav>

    <!-- Header Judul -->
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">FR.IA.07 – Lembar Pertanyaan Lisan</h4>
        <p class="text-muted mb-1">Skema Sertifikasi Kompetensi</p>
        <div class="d-inline-block mb-2">
            <button class="btn" style="background-color:#041562; color:#fff;" type="button">
                {{ strtoupper($skema->nama_skema) }}
            </button>
        </div>
        <p class="text-muted">{{ $skema->kode_skema ?? 'N/A' }}</p>
    </div>

    <!-- Panduan -->
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-header" style="background-color:#f0f6ff; color:#333; font-weight:bold;">
            Panduan Bagi Asesor
        </div>
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item border-0 ps-0">Buatlah pertanyaan lisan yang dapat menguji kemampuan komunikasi, pemahaman konsep, serta keterampilan praktis dari peserta uji.</li>
                <li class="list-group-item border-0 ps-0">Pertanyaan lisan sebaiknya singkat, jelas, dan dapat dijawab secara langsung oleh peserta.</li>
                <li class="list-group-item border-0 ps-0">Asesor dapat menyesuaikan pertanyaan sesuai dengan unit kompetensi yang sedang diuji.</li>
            </ol>
        </div>
    </div>

    @php
        $semuaPembuatan   = $pembuatanList->sortByDesc('id_pembuatan_pertanyaan');
        $pembuatanTerbaru = $semuaPembuatan->first();
    @endphp

    <!-- Daftar Set Pertanyaan Lisan -->
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#f9fbff; font-weight:bold;">
            <span>Daftar Set Pertanyaan Lisan</span>
            <small class="text-muted fw-normal" id="paginationInfo"></small>
        </div>
        <div class="card-body">
            @if($semuaPembuatan->isEmpty())
                <p class="text-muted">Belum ada pembuatan pertanyaan untuk skema ini.</p>
            @else
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Timer</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelLisan">
                        @foreach($semuaPembuatan as $p)
                        <tr class="lisan-row">
                            <td>{{ $p->id_pembuatan_pertanyaan }}</td>
                            <td>{{ $p->judul ?? 'Set Lisan #' . $p->id_pembuatan_pertanyaan }}</td>
                            <td>{{ $p->timer }} menit</td>
                            <td>{{ $p->timescap ? \Carbon\Carbon::parse($p->timescap)->format('d-m-Y H:i') : '-' }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('pertanyaan.lisan.kelompok', [
                                        'id_skema'     => $skema->id_skema,
                                        'id_pembuatan' => $p->id_pembuatan_pertanyaan,
                                        'timer'        => $p->timer,
                                    ]) }}" class="btn btn-sm btn-primary">
                                        Lanjutkan
                                    </a>
                                    <a href="{{ route('lisan.crud', $skema->id_skema) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        Lihat
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="konfirmasiHapusSet({{ $p->id_pembuatan_pertanyaan }}, '{{ addslashes($p->judul ?? 'Set Lisan #'.$p->id_pembuatan_pertanyaan) }}')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="d-flex justify-content-center align-items-center gap-2 mt-3" id="paginationControls">
                    <button class="btn btn-sm btn-outline-secondary" id="btnPrev" onclick="changePage(-1)" disabled>
                        &laquo; Prev
                    </button>
                    <div id="pageNumbers" class="d-flex gap-1"></div>
                    <button class="btn btn-sm btn-outline-secondary" id="btnNext" onclick="changePage(1)">
                        Next &raquo;
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol Selanjutnya -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#041562;"
                data-bs-toggle="modal" data-bs-target="#modalPilihan">
            Selanjutnya
        </button>
    </div>

</div>

<!-- Form hidden untuk DELETE -->
<form id="formHapusSet" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- ===== Modal Pilihan ===== -->
<div class="modal fade" id="modalPilihan" tabindex="-1" aria-labelledby="modalPilihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPilihanLabel">Pilih Aksi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <button type="button"
                    class="btn w-100 mb-2 text-white fw-bold"
                    style="background-color:#041562;"
                    data-bs-dismiss="modal"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTimerLisan">
                    + Buat Set Pertanyaan Baru
                </button>

                @if($pembuatanTerbaru)
                    <a href="{{ route('lisan.crud', $skema->id_skema) }}"
                       class="btn w-100 fw-bold"
                       style="background-color:#f1f1f1; color:#333;">
                        Lihat Pertanyaan
                    </a>
                @else
                    <button class="btn w-100 fw-bold" style="background-color:#f1f1f1; color:#333;" disabled>
                        Belum ada pertanyaan lisan
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ===== Modal Atur Timer & Judul Lisan ===== -->
<div class="modal fade" id="modalTimerLisan" tabindex="-1" aria-labelledby="modalTimerLisanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalTimerLisanLabel">Atur Timer & Judul</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Pembuatan Pertanyaan <span class="text-danger">*</span></label>
                    <input type="text" id="inputJudulLisan" class="form-control"
                           placeholder="Contoh: Lisan Skema A Batch 1">
                    <div class="invalid-feedback">Judul wajib diisi.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Timer (menit) <span class="text-danger">*</span></label>
                    <input type="number" id="inputTimerLisan" class="form-control" value="30" min="1">
                    <div class="invalid-feedback">Timer wajib diisi dan minimal 1 menit.</div>
                </div>
                <button type="button" class="btn w-100 text-white fw-bold"
                        style="background-color:#041562;"
                        onclick="lanjutBuatSetLisan()">
                    Buat Baru
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function lanjutBuatSetLisan() {
    const judul = document.getElementById('inputJudulLisan').value.trim();
    const timer = document.getElementById('inputTimerLisan').value.trim();

    if (!judul) {
        document.getElementById('inputJudulLisan').classList.add('is-invalid');
        return;
    } else {
        document.getElementById('inputJudulLisan').classList.remove('is-invalid');
    }

    if (!timer || parseInt(timer) < 1) {
        document.getElementById('inputTimerLisan').classList.add('is-invalid');
        return;
    } else {
        document.getElementById('inputTimerLisan').classList.remove('is-invalid');
    }

    let url = `{{ route('kelompok.pekerjaan.lisan', ['id' => $skema->id_skema]) }}?timer=${timer}&judul=${encodeURIComponent(judul)}`;
    window.location.href = url;
}

function konfirmasiHapusSet(idPembuatan, judul) {
    Swal.fire({
        title: 'Hapus Set Pertanyaan?',
        html: `Set "<strong>${judul}</strong>" dan semua soal di dalamnya akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'btn btn-danger fw-bold px-4 me-2',
            cancelButton: 'btn btn-secondary fw-bold px-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('formHapusSet');
            form.action = `{{ url('/lisan/set') }}/${idPembuatan}`;
            form.submit();
        }
    });
}

// ===== PAGINATION =====
const itemsPerPage = 10;
let currentPage = 1;

const rows = document.querySelectorAll('.lisan-row');
const totalItems = rows.length;
const totalPages = Math.ceil(totalItems / itemsPerPage);

function renderTable() {
    const start = (currentPage - 1) * itemsPerPage;
    const end   = start + itemsPerPage;

    rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? '' : 'none';
    });

    const infoEl = document.getElementById('paginationInfo');
    if (infoEl) {
        const from = start + 1;
        const to   = Math.min(end, totalItems);
        infoEl.textContent = `Menampilkan ${from}–${to} dari ${totalItems} data`;
    }

    document.getElementById('btnPrev').disabled = currentPage === 1;
    document.getElementById('btnNext').disabled = currentPage === totalPages;

    const pageNumbersEl = document.getElementById('pageNumbers');
    pageNumbersEl.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = `btn btn-sm ${i === currentPage ? 'text-white' : 'btn-outline-secondary'}`;
        btn.style.cssText = i === currentPage
            ? 'min-width:34px; background-color:#041562;'
            : 'min-width:34px;';
        btn.onclick = () => { currentPage = i; renderTable(); };
        pageNumbersEl.appendChild(btn);
    }
}

function changePage(dir) {
    currentPage += dir;
    if (currentPage < 1) currentPage = 1;
    if (currentPage > totalPages) currentPage = totalPages;
    renderTable();
}

if (totalItems <= itemsPerPage) {
    const ctrl = document.getElementById('paginationControls');
    if (ctrl) ctrl.style.display = 'none';
}

renderTable();
</script>

@endsection