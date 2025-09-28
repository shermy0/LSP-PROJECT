@extends('master')

@section('title', 'Form Pra Asesmen')

@section('konten')
<div class="container mt-4">

    <div class="form-header text-center mb-4">
        <h2 class="fw-bold">Form Pra Asesmen</h2>
        <p class="text-muted">Sistem Manajemen Asesmen Siswa - AsesKom</p>
        <div class="line"></div>
    </div>

    <!-- Card Pra Asesmen -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-semibold">
            Pra Asesmen
        </div>
        <div class="card-body">

            {{-- FR.APL.01 Permohonan Sertifikasi Kompetensi --}}
            @php
                $status = $permohonan->status ?? null;

                if (!$permohonan) {
                    $link = route('asesi.permohonan.form1');
                    $disabled = false;
                } elseif ($status == 'Diajukan') {
                    $link = route('asesi.permohonan.menunggu');
                    $disabled = false;
                } elseif ($status == 'Diterima') {
                    $link = '#'; // tidak bisa isi lagi
                    $disabled = true;
                } else {
                    $link = route('asesi.permohonan.form1');
                    $disabled = false;
                }
            @endphp

            <a href="{{ $disabled ? 'javascript:void(0)' : $link }}" 
               class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none {{ $disabled ? 'disabled' : '' }}"
               @if($disabled) onclick="return false;" @endif>
                <div class="d-flex align-items-start">
                    <div class="icon-wrap me-3">📄</div>
                    <div>
                        <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                        <small class="text-muted">
                            @if($permohonan)
                                Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}
                            @else
                                Tanggal: -
                            @endif
                        </small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge 
                        @if(!$permohonan) bg-secondary
                        @elseif($status == 'Diterima') bg-success
                        @elseif($status == 'Ditolak') bg-danger
                        @elseif($status == 'Diajukan') bg-warning text-dark
                        @else bg-secondary @endif">
                        {{ $permohonan ? $status : 'Belum diisi' }}
                    </span>
                </div>
            </a>

            {{-- FR.APL.02 Asesmen Mandiri (muncul hanya jika permohonan diterima) --}}
            @if($status == 'Diterima')
                @php
                    // $asesmenMandiri diambil oleh controller (boleh null / object)
                    // bisa berisi fields: id_asesmen_mandiri, rekomendasi, updated_at, id_asesor, dsb.
                    $asesmenExists = !empty($asesmenMandiri);
                    $rekom = $asesmenExists ? ($asesmenMandiri->rekomendasi ?? null) : null;

                    if (!$asesmenExists) {
                        $asesmenLabel = 'Belum diisi';
                        $asesmenBadge = 'bg-secondary';
                        $asesmenHref = route('asesi.asesmen_mandiri.form1');
                        $asesmenData = null;
                    } else {
                        // ada asesmen mandiri (sudah diisi oleh asesi)
                        if (empty($rekom)) {
                            // belum direkomendasikan -> di periksa
                            $asesmenLabel = 'Di Periksa';
                            $asesmenBadge = 'bg-warning text-dark';
                            // menuju halaman waiting (tunggu verifikasi admin)
                            $asesmenHref = route('asesi.asesmen_mandiri.waiting'); // pastikan route ini ada
                        } elseif ($rekom === 'Dapat Dilanjutkan') {
                            $asesmenLabel = 'Dapat Dilanjutkan';
                            $asesmenBadge = 'bg-success';
                            // link kept but we will open modal instead via JS (so keep href="#")
                            $asesmenHref = 'javascript:void(0)';
                        } else {
                            // 'Tidak Dapat Dilanjutkan'
                            $asesmenLabel = 'Tidak Dapat Dilanjutkan';
                            $asesmenBadge = 'bg-danger';
                            $asesmenHref = 'javascript:void(0)';
                        }

                        // data for modal
                        $asesmenData = [
                            'id' => $asesmenMandiri->id_asesmen_mandiri,
                            'rekomendasi' => $rekom,
                            'updated_at' => $asesmenMandiri->updated_at ?? $asesmenMandiri->created_at ?? null,
                            'id_asesor' => $asesmenMandiri->id_asesor ?? null,
                        ];
                    }
                @endphp

                <a href="{{ $asesmenHref }}"
                   class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none"
                   id="link-asesmen-mandiri"
                   @if($asesmenExists)
                        data-asesmen='@json($asesmenData)'
                   @endif>
                    <div class="d-flex align-items-start">
                        <div class="icon-wrap me-3">✅</div>
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                            <small class="text-muted">
                                @if($asesmenExists)
                                    Terakhir diisi: {{ $asesmenMandiri->updated_at ?? $asesmenMandiri->created_at ?? '-' }}
                                @else
                                    Silakan lanjutkan mengisi asesmen mandiri setelah permohonan diterima.
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $asesmenBadge }}">{{ $asesmenLabel }}</span>
                    </div>
                </a>
            @endif

        </div>
    </div>

</div>

{{-- Modal untuk menampilkan detail rekomendasi / instruksi --}}
<div class="modal fade" id="asesmenModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asesmenModalTitle">Detail Asesmen Mandiri</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="asesmenModalBody">
        <!-- diisi oleh JS -->
        <p class="mb-2"><strong>Rekomendasi:</strong> <span id="modalRekom"></span></p>
        <p class="mb-2"><strong>Terakhir diperbarui:</strong> <span id="modalUpdated"></span></p>
        <p class="mb-2"><strong>Catatan / Keterangan:</strong></p>
        <div id="modalCatatan" class="small text-muted">-</div>
      </div>
      <div class="modal-footer">
        <a href="#" id="modalPrimaryBtn" class="btn btn-primary">Lanjutkan</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Style langsung di blade --}}
<style>
    .form-header h2 {
        color: #041562;
    }
    .form-header .line {
        width: 80px;
        height: 3px;
        background: #041562;
        margin: 10px auto;
        border-radius: 2px;
    }
    .card-header {
        background: #f0f7ff !important;
        color: #041562;
        border-bottom: 2px solid #041562;
    }
    .pra-item {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
        transition: 0.2s;
        color: inherit;
        cursor: pointer;
    }
    .pra-item:hover {
        background: #f8fafc;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        text-decoration: none;
    }
    .pra-item.disabled {
        background: #f1f1f1;
        color: #999 !important;
        cursor: not-allowed;
        pointer-events: none;
    }
    .icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #041562;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
    }
</style>

{{-- Script untuk handle klik & modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const link = document.getElementById('link-asesmen-mandiri');
    if (!link) return;

    link.addEventListener('click', function (e) {
        // ambil data asesmen (jika ada)
        const dataStr = link.getAttribute('data-asesmen');
        if (!dataStr) {
            // tidak ada asesmen -> biarkan link normal mengarahkan ke form
            return;
        }

        const data = JSON.parse(dataStr);

        // jika rekomendasi null -> status "Di Periksa" -> arahkan ke waiting page
        if (!data.rekomendasi) {
            e.preventDefault();
            // pastikan route 'asesi.asesmen_mandiri.waiting' ada; jika tidak, ganti dengan route show
            window.location.href = "{{ route('asesi.asesmen_mandiri.waiting') }}";
            return;
        }

        // jika rekomendasi ada -> tampilkan modal dengan detail
        e.preventDefault();
        const rekom = data.rekomendasi;
        const updated = data.updated_at || '-';
        const id = data.id;

        document.getElementById('modalRekom').textContent = rekom;
        document.getElementById('modalUpdated').textContent = updated;

        // optional: ambil catatan via AJAX jika Anda menyimpan catatan di tabel persetujuan
        // untuk sementara tampilkan placeholder / catatan default
        document.getElementById('modalCatatan').textContent = 'Lihat detail rekomendasi dari asesor.';

        const primaryBtn = document.getElementById('modalPrimaryBtn');

        if (rekom === 'Dapat Dilanjutkan') {
            primaryBtn.textContent = 'Lanjutkan';
            // arahkan ke halaman show asesmen (atau halaman selanjutnya)
            primaryBtn.href = "{{ url('/') }}" + "/asesi/asesmen-mandiri/" + id; // route('asesi.asesmen_mandiri.show', id)
            primaryBtn.classList.remove('btn-danger');
            primaryBtn.classList.add('btn-primary');
            primaryBtn.style.display = 'inline-block';
        } else {
            // Tidak Dapat Dilanjutkan
            primaryBtn.textContent = 'Isi Ulang Asesmen';
            primaryBtn.href = "{{ route('asesi.asesmen_mandiri.form1') }}";
            primaryBtn.classList.remove('btn-primary');
            primaryBtn.classList.add('btn-danger');
            primaryBtn.style.display = 'inline-block';
        }

        // tampilkan modal
        const modalEl = document.getElementById('asesmenModal');
        const bsModal = new bootstrap.Modal(modalEl);
        bsModal.show();
    });
});
</script>

@endsection
