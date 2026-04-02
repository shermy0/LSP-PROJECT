@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <form id="asesmenForm" action="{{ route('asesi.asesmen_mandiri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                    </svg>
                </div>
                <h1 class="display-6 fw-bold text-dark">Asesmen Mandiri</h1>
                <p class="text-secondary">Form Asesmen FR.APL.02 – Penilaian mandiri oleh asesi</p>
            </div>

            @foreach($units as $unit)
                <!-- Card Unit Kompetensi -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-grid-3x3-gap-fill text-primary" viewBox="0 0 16 16">
                                    <path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Unit Kompetensi {{ $loop->iteration }}</h5>
                                <p class="text-secondary mb-0 small">Kode Unit: {{ $unit->kode_unit }} | {{ $unit->judul_unit }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-3">
                        @php
                            $elemenUnit = $elemen->where('id_unit', $unit->id_unit);
                        @endphp

                        @foreach($elemenUnit as $e)
                            <!-- Elemen card -->
                            <div class="elemen-card mb-3">
                                <div class="elemen-header">
                                    <span class="elemen-number">{{ $loop->iteration }}</span>
                                    <span class="fw-semibold">{{ $e->judul_elemen }}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:5%">No</th>
                                                <th style="width:60%">Elemen</th>
                                                <th style="width:8%" class="text-center">K</th>
                                                <th style="width:8%" class="text-center">BK</th>
                                                <th style="width:19%">Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $kukElemen = $kuk->where('id_elemen', $e->id_elemen);
                                            @endphp
                                            @foreach($kukElemen as $k)
                                                @php
                                                    $jawab = $jawaban[$k->id_kuk] ?? null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="td-deskripsi">
                                                        {{ $k->deskripsi_kuk }}
                                                        <div class="invalid-msg text-danger small"></div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="K" class="radio-kuk form-check-input" required {{ $jawab && $jawab->status == 'K' ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="BK" class="radio-kuk form-check-input" {{ $jawab && $jawab->status == 'BK' ? 'checked' : '' }}>
                                                    </td>
                                                    <td>
                                                        <select name="bukti[{{ $k->id_kuk }}]" class="form-select bukti-select" required>
                                                            <option value="">Pilih Dokumen</option>
                                                            @foreach($dokumen as $d)
                                                                <option value="{{ $d->id_dokumen }}" {{ $jawab && $jawab->id_dokumen == $d->id_dokumen ? 'selected' : '' }}>
                                                                    {{ $d->nama_jenis }} ({{ basename($d->file_path) }})
                                                                </option>
                                                            @endforeach
                                                            <option value="upload_lain" {{ $jawab && $jawab->id_dokumen == null && $jawab->file_lain ? 'selected' : '' }}>+ Upload file lain</option>
                                                        </select>
                                                        <div class="invalid-msg text-danger small"></div>
                                                        
                                                        <!-- Wrapper untuk upload file lain -->
                                                        <div class="upload-lain-wrapper mt-2" style="display: {{ $jawab && $jawab->id_dokumen == null && $jawab->file_lain ? 'block' : 'none' }};">
                                                            <input type="file" name="file_lain[{{ $k->id_kuk }}]" class="form-control file-lain-input" accept=".pdf,.jpg,.jpeg,.png">
                                                            <div class="file-lain-info small text-muted mt-1">
                                                                @if($jawab && $jawab->file_lain)
                                                                    <strong>File tersimpan:</strong> {{ basename($jawab->file_lain) }}
                                                                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="hapusFileLain(this)">Hapus</button>
                                                                    <input type="hidden" name="hapus_file_lain[{{ $k->id_kuk }}]" value="0" class="hapus-file-lain-flag">
                                                                @endif
                                                            </div>
                                                        </div>
                                                     </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Tombol navigasi -->
            <div class="button-group mt-4">
                <a href="{{ route('asesi.asesmen_mandiri.form1') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next">
                    Simpan dan Lanjut
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <style>
        /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
        :root {
            --primary: #0b2f7c;
            --primary-dark: #08205c;
            --primary-light: #1a3e9c;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f1f4f9;
        }

        .container-fluid {
            max-width: 1280px;
            margin: 0 auto;
        }

        .card {
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .card:hover {
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
        }

        .card-header {
            background: transparent;
            padding-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: #fff;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
            outline: none;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-primary.bg-gradient {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(11,47,124,0.1) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .elemen-card {
            background: #ffffff;
            border: 1px solid #e9edf4;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .elemen-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            background: #f8fbff;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid var(--primary);
        }

        .elemen-number {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .table thead th {
            background: #f0f5ff;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #d0d9e8;
            padding: 0.75rem;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            background: white;
            border-bottom: 1px solid #e9edf4;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            border: 2px solid #b0c4de;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .is-invalid {
            border: 2px solid var(--danger) !important;
            background: #fff8f8 !important;
        }

        .td-deskripsi.is-invalid {
            border: 2px solid var(--danger);
            border-radius: 0.5rem;
            padding: 0.75rem !important;
        }

        .invalid-msg {
            font-size: 0.75rem;
            color: var(--danger);
            margin-top: 0.2rem;
        }

        .btn-next {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 0.7rem 1.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(11,47,124,0.3);
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-next:hover {
            background: linear-gradient(135deg, var(--primary-dark), #061944);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(11,47,124,0.35);
            color: #fff;
        }

        .btn-back {
            background-color: #fff;
            color: var(--secondary);
            padding: 0.7rem 1.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            border: 1.5px solid #dee2e6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #f1f3f5;
            color: #495057;
            border-color: #ced4da;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
            .table thead th {
                font-size: 0.75rem;
                padding: 0.5rem;
            }
            .table tbody td {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
            .form-select {
                font-size: 0.8rem;
                padding: 0.3rem 0.6rem;
            }
            .elemen-header {
                flex-wrap: wrap;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('asesmenForm');
            const radios = form.querySelectorAll('.radio-kuk');
            const selects = form.querySelectorAll('.bukti-select');

            // Fungsi untuk menampilkan/menyembunyikan input file upload lain
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const wrapper = this.closest('td').querySelector('.upload-lain-wrapper');
                    if (this.value === 'upload_lain') {
                        wrapper.style.display = 'block';
                    } else {
                        wrapper.style.display = 'none';
                        // Reset input file jika tidak dipilih
                        const fileInput = wrapper.querySelector('.file-lain-input');
                        if (fileInput) fileInput.value = '';
                    }
                });
            });

            // Validasi manual
            radios.forEach(radio => {
                radio.addEventListener('invalid', function (event) {
                    const tr = this.closest('tr');
                    const tdDesc = tr.querySelector('.td-deskripsi');
                    tdDesc.classList.add('is-invalid');
                    const msg = tdDesc.querySelector('.invalid-msg');
                    msg.innerText = 'Pilih K atau BK';
                    event.preventDefault();
                });

                radio.addEventListener('change', function () {
                    const tr = this.closest('tr');
                    const tdDesc = tr.querySelector('.td-deskripsi');
                    tdDesc.classList.remove('is-invalid');
                    const msg = tdDesc.querySelector('.invalid-msg');
                    msg.innerText = '';
                });
            });

            selects.forEach(select => {
                select.addEventListener('invalid', function (event) {
                    this.classList.add('is-invalid');
                    const msg = this.parentElement.querySelector('.invalid-msg');
                    msg.innerText = 'Wajib pilih bukti';
                    event.preventDefault();
                });

                select.addEventListener('change', function () {
                    this.classList.remove('is-invalid');
                    const msg = this.parentElement.querySelector('.invalid-msg');
                    msg.innerText = '';
                });
            });

            // Prevent default HTML5 validation bubbles
            form.addEventListener('invalid', function (e) {
                e.preventDefault();
            }, true);

            // Validasi tambahan untuk file lain: jika pilih upload_lain tetapi file tidak diupload
            form.addEventListener('submit', function(e) {
                let isValid = true;
                document.querySelectorAll('.bukti-select').forEach(select => {
                    if (select.value === 'upload_lain') {
                        const wrapper = select.closest('td').querySelector('.upload-lain-wrapper');
                        const fileInput = wrapper.querySelector('.file-lain-input');
                        const hapusFlag = wrapper.querySelector('.hapus-file-lain-flag');
                        const hasExistingFile = wrapper.querySelector('.file-lain-info strong') !== null;
                        // Jika tidak ada file baru dan tidak ada file lama (atau file lama dihapus)
                        if ((!fileInput || fileInput.files.length === 0) && (!hasExistingFile || (hapusFlag && hapusFlag.value === '1'))) {
                            select.classList.add('is-invalid');
                            const msg = select.parentElement.querySelector('.invalid-msg');
                            msg.innerText = 'Harap upload file bukti';
                            isValid = false;
                        }
                    }
                });
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });

        // Fungsi global untuk hapus file lain
        function hapusFileLain(btn) {
            const wrapper = btn.closest('.upload-lain-wrapper');
            const fileInput = wrapper.querySelector('.file-lain-input');
            const infoDiv = wrapper.querySelector('.file-lain-info');
            const flagInput = wrapper.querySelector('.hapus-file-lain-flag');
            if (fileInput) fileInput.value = '';
            if (infoDiv) infoDiv.innerHTML = '';
            if (flagInput) flagInput.value = '1';
            wrapper.style.display = 'none';
            // Ubah pilihan select kembali ke opsi default
            const select = wrapper.closest('td').querySelector('.bukti-select');
            if (select) select.value = '';
        }
    </script>
@endsection