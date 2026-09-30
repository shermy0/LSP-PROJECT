@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
    <div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>


<div class="container mt-4">
    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.MAPA 01. Merencanakan Aktivitas dan Proses</h3>
        <p class="text-muted">Peninjauan Proses Asesmen</p>
    </div>
    <!-- skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>
    
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mapa-box">
            <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
            <div class="jenis-skema">
<input type="radio" id="kkni" name="skema" class="form-check-input me-2"
       value="KKNI"
       @if(\Illuminate\Support\Str::contains($skema->jenjang, 'KKNI')) checked @endif disabled>
<label for="kkni">KKNI</label>



                <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                       value="Okupasi"
                       @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                <label for="okupasi">Okupasi</label>
            </div>
            </div>
            </div>

            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                    <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('form.mapa01.store', $skema->id_skema) }}" method="POST">
    @csrf
    <!-- Menentukan Pendekatan Asesmen -->
<div class="mapa-section">
    <div class="card mapa-card">
                <div class="judul-header">Menentukan Pendekatan Asesmen</div>

            <div class="mapa-subsection">
                <div class="mapa-subsection-header">Asesi</div>
                <div class="mapa-options">
                    <div>
                        <input class="form-check-input" type="checkbox" name="pelatihan_standar" id="pelatihan_standar"
            {{ $pendekatan && $pendekatan->pelatihan_standar ? 'checked' : '' }}>
                        <label for="asesi1">Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</label>
                    </div>
                    <div>
                         <input class="form-check-input" type="checkbox" name="pelatihan_nonstandar" id="pelatihan_nonstandar"
            {{ $pendekatan && $pendekatan->pelatihan_nonstandar ? 'checked' : '' }}>
                        <label for="asesi2">Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" name="pengalaman_standar" id="pengalaman_standar"
            {{ $pendekatan && $pendekatan->pengalaman_standar ? 'checked' : '' }}>
                        <label for="asesi3">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</label>
                    </div>
                    <div>
                       <input class="form-check-input" type="checkbox" name="pengalaman_nonstandar" id="pengalaman_nonstandar"
            {{ $pendekatan && $pendekatan->pengalaman_nonstandar ? 'checked' : '' }}>
                        <label for="asesi4">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" name="otodidak" id="otodidak"
            {{ $pendekatan && $pendekatan->otodidak ? 'checked' : '' }}>
                        <label for="asesi5">Pelatihan / belajar mandiri atau otodidak.</label>
                    </div>
            </div>
<!-- Tujuan Asesmen -->
<div class="mapa-section">
    <div class="mapa-subsection-header">Tujuan Asesmen</div>
    <div class="mapa-options" id="tujuan-asesmen-list">
        {{-- Default tujuan (tidak bisa dihapus/diubah) --}}
        @foreach($defaultTujuan as $nama)
            <div class="tujuan-item">
                <input type="checkbox" name="tujuan[]" value="{{ $nama }}"
                       class="form-check-input me-2"
                       @if(in_array($nama, $tujuanDipilih ?? [])) checked @endif>
                <label>{{ $nama }}</label>
            </div>
        @endforeach

        {{-- Custom tujuan (bisa edit & hapus) --}}
        @foreach($customTujuan as $nama)
            @php
                $tujuan = DB::table('tujuan_asesmen')->where('nama_tujuan', $nama)->first();
            @endphp
            <div class="tujuan-item">
                <input type="checkbox" name="tujuan[]" value="{{ $nama }}"
                       class="form-check-input me-2"
                       @if(in_array($nama, $tujuanDipilih ?? [])) checked @endif>
                <label>{{ $nama }}</label>

                <button type="button" class="btn btn-sm btn-warning edit-tujuan"
                        data-id="{{ $tujuan->id_tujuan }}"
                        data-nama="{{ $nama }}">Edit</button>

                <button type="button" 
                        class="btn btn-sm btn-danger delete-tujuan"
                        data-url="{{ route('mapa01.tujuan.delete', ['skema' => $skema->id_skema, 'tujuan' => $tujuan->id_tujuan]) }}">
                    Hapus
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#modalTambahTujuan">
        + Tambah opsi tujuan lainnya
    </button>
</div>



<!-- Modal Tambah Opsi -->
<div class="modal fade" id="modalTambahTujuan" tabindex="-1" aria-labelledby="modalTambahTujuanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalTambahTujuanLabel">Tambah Tujuan Asesmen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="tujuanBaru" class="form-label">Nama Tujuan Asesmen</label>
        <input type="text" id="tujuanBaru" class="form-control" placeholder="Contoh: Uji Kompetensi Khusus">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="simpanTujuan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal edit Opsi -->
<div class="modal fade" id="modalEditTujuan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Tujuan Asesmen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editIdTujuan">
        <input type="text" id="editNamaTujuan" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnUpdateTujuan">Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- KONTEKS ASESMEN -->
<div class="mapa-section">
    <div class="mapa-subsection-header">Konteks Asesmen</div>
    <div class="konteks-section">

        <!-- LINGKUNGAN -->
        <div class="form-group mb-3">
            <label class="form-label d-block">Lingkungan</label>
            <label class="me-3">
                <input type="radio" name="lingkungan" value="Tempat kerja nyata" class="form-check-input me-1"
                       {{ $konteks->lingkungan == 'Tempat kerja nyata' ? 'checked' : '' }}>
                Tempat kerja nyata
            </label>
            <label>
                <input type="radio" name="lingkungan" value="Tempat kerja simulasi" class="form-check-input me-1"
                       {{ $konteks->lingkungan == 'Tempat kerja simulasi' ? 'checked' : '' }}>
                Tempat kerja simulasi
            </label>
        </div>

        <!-- PELUANG -->
        <div class="form-group mb-3">
            <label class="form-label d-block">Peluang untuk mengumpulkan bukti dalam sejumlah situasi</label>
            <label class="me-3">
                <input type="radio" name="peluang" value="Tersedia" class="form-check-input me-1"
                       {{ $konteks->peluang == 'Tersedia' ? 'checked' : '' }}>
                Tersedia
            </label>
            <label>
                <input type="radio" name="peluang" value="Terbatas" class="form-check-input me-1"
                       {{ $konteks->peluang == 'Terbatas' ? 'checked' : '' }}>
                Terbatas
            </label>
        </div>

        <!-- HUBUNGAN -->
<div class="form-group mb-3">
    <label class="form-label d-block mb-2">Hubungan antara standar kompetensi dan:</label>

    <div class="hubungan-list">
        @foreach(['Bukti untuk mendukung asesmen','Aktivitas kerja di tempat kerja Asesi','Kegiatan Pembelajaran'] as $h)
        @php
            $selected = $konteks->hubungan_rating[$h] ?? '';
            $checked = in_array($h, $konteks->hubungan);
        @endphp
        <div class="hubungan-item">
            <label class="d-flex align-items-center flex-grow-1">
                <input type="checkbox" 
                       name="hubungan[]" 
                       value="{{ $h }}" 
                       class="form-check-input me-2 hubungan-checkbox"
                       {{ $checked ? 'checked' : '' }}
                       data-name="{{ $h }}">
                <span class="hubungan-text">{{ $h }}</span>
            </label>

            <div class="emoji-group ms-3 {{ $checked ? '' : 'disabled' }}">
                <div class="emoji-option {{ $selected === 'senang' ? 'active' : '' }}" data-value="senang" data-name="{{ $h }}">😊</div>
                <div class="emoji-option {{ $selected === 'datar' ? 'active' : '' }}" data-value="datar" data-name="{{ $h }}">😐</div>
                <div class="emoji-option {{ $selected === 'sedih' ? 'active' : '' }}" data-value="sedih" data-name="{{ $h }}">☹️</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Hidden inputs untuk backend --}}
    <div id="emoji-hidden-inputs">
        @foreach($konteks->hubungan_rating ?? [] as $key => $val)
            <input type="hidden" name="hubungan_rating[{{ $key }}]" value="{{ $val }}">
        @endforeach
    </div>
</div>


<div class="mapa-subsection-header">Konfirmasi dengan Orang Lain yang Relevan</div>
<div class="mapa-options">
    <div>
        <input type="checkbox" class="form-check-input me-2"  name="orang_relevan[]" value="Manajer sertifikasi LSP P1 SMKN 11 Bandung"
    @if($konfirmasi && $konfirmasi->konfirmasi_manajer_lsp) checked @endif>
Manajer sertifikasi LSP P1 SMKN 11 Bandung
    </div>
    <div>
        <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Master Asesor / Master Trainer / Lead Asesor Kompetensi"
    @if($konfirmasi && $konfirmasi->konfirmasi_master_asesor) checked @endif>
Master Asesor / Master Trainer / Lead Asesor Kompetensi
    </div>
    <div>
       <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar"
    @if($konfirmasi && $konfirmasi->konfirmasi_manajer_pelatihan) checked @endif>
Manajer Pelatihan Lembaga Training
    </div>
    <div>
       <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Manajer atau supervisor di tempat kerja"
    @if($konfirmasi && $konfirmasi->konfirmasi_supervisor) checked @endif>
Manajer atau supervisor di tempat kerja
    </div>
</div>




<div class="mapa-subsection-header">Standar Industri atau Tempat Kerja</div>
<div class="mapa-options">
{{-- Standar Kompetensi --}}
<div>
    @foreach($standarKompetensi as $sk)
        <input type="checkbox" class="form-check-input me-2" checked disabled>
        <label>Standar Kompetensi: {{ $sk }}</label>
    @endforeach
</div>


{{-- Kriteria Asesmen dari Kurikulum Pelatihan --}}
<div>
    <input type="checkbox" id="asesi2" name="kriteria_asesmen"
           value="1" class="form-check-input me-2"
           {{ isset($standar) && $standar->standar_kriteria_asesmen ? 'checked' : '' }}>
    <label for="asesi2">Kriteria asesmen dari kurikulum pelatihan</label>
</div>

{{-- Spesifikasi Kinerja Perusahaan --}}
<div>
    <input type="checkbox" id="asesi3" class="form-check-input me-2 toggle-input"
           data-target="input-asesi3"
           {{ isset($standar) && $standar->standar_kinerja_perusahaan ? 'checked' : '' }}>
    <label for="asesi3">Spesifikasi kinerja suatu perusahaan atau industri</label>
    <input type="text" id="input-asesi3" name="standar_kinerja_perusahaan"
           class="form-control mt-2"
           value="{{ $standar->standar_kinerja_perusahaan ?? '' }}"
           {{ isset($standar) && $standar->standar_kinerja_perusahaan ? '' : 'disabled style=display:none;' }}>
</div>

{{-- Spesifikasi Produk --}}
<div>
    <input type="checkbox" id="asesi4" class="form-check-input me-2 toggle-input"
           data-target="input-asesi4"
           {{ isset($standar) && $standar->standar_spesifikasi_produk ? 'checked' : '' }}>
    <label for="asesi4">Spesifikasi Produk:</label>
    <input type="text" id="input-asesi4" name="spesifikasi_produk"
           class="form-control mt-2" placeholder="Isi spesifikasi produk"
           value="{{ $standar->standar_spesifikasi_produk ?? '' }}"
           {{ isset($standar) && $standar->standar_spesifikasi_produk ? '' : 'disabled style=display:none;' }}>
</div>

{{-- Pedoman Khusus --}}
<div>
    <input type="checkbox" id="asesi5" class="form-check-input me-2 toggle-input"
           data-target="input-asesi5"
           {{ isset($standar) && $standar->standar_pedoman_khusus ? 'checked' : '' }}>
    <label for="asesi5">Pedoman Khusus:</label>
    <input type="text" id="input-asesi5" name="pedoman_khusus"
           class="form-control mt-2" placeholder="Isi pedoman khusus"
           value="{{ $standar->standar_pedoman_khusus ?? '' }}"
           {{ isset($standar) && $standar->standar_pedoman_khusus ? '' : 'disabled style=display:none;' }}>
</div>

</div>


        
    </div>
</div>
<!-- Simpan dan Lanjut -->
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-input").forEach(cb => {
        cb.addEventListener("change", function () {
            const target = document.getElementById(this.dataset.target);
            if (this.checked) {
                target.style.display = "block";
                target.disabled = false;
            } else {
                target.style.display = "none";
                target.disabled = true;
                target.value = ""; // biar ga ikut ke DB
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const tujuanList = document.getElementById("tujuan-asesmen-list");
    let currentEditId = null; // simpan id tujuan yang lagi di-edit

    // Tambah tujuan baru lewat modal
    document.getElementById("simpanTujuan").addEventListener("click", function () {
        const nama = document.getElementById("tujuanBaru").value.trim();
        if (!nama) return;

        const id = "tujuan_" + Date.now();
        const wrapper = document.createElement("div");
        wrapper.classList.add("tujuan-item");
        wrapper.innerHTML = `
            <input type="checkbox" name="tujuan[]" value="${nama}" id="${id}" checked class="form-check-input me-2">
            <label for="${id}" class="tujuan-label">${nama}</label>
            <button type="button" class="btn btn-sm btn-warning edit-tujuan" data-id="${id}" data-nama="${nama}">Edit</button>
            <button type="button" class="btn btn-sm btn-danger delete-tujuan">Hapus</button>
        `;
        tujuanList.appendChild(wrapper);

        document.getElementById("tujuanBaru").value = "";
        bootstrap.Modal.getInstance(document.getElementById("modalTambahTujuan")).hide();
    });

    // Delegasi event untuk Edit & Delete
    tujuanList.addEventListener("click", function (e) {
        const item = e.target.closest(".tujuan-item");
        if (!item) return;

        // === Edit tujuan ===
        if (e.target.classList.contains("edit-tujuan")) {
            currentEditId = e.target.getAttribute("data-id"); // simpan id tujuan yg diedit
            const nama = e.target.getAttribute("data-nama");

            document.getElementById("editNamaTujuan").value = nama;

            // Tampilkan modal edit
            const modal = new bootstrap.Modal(document.getElementById("modalEditTujuan"));
            modal.show();
        }

        // === Delete tujuan ===
if (e.target.classList.contains("delete-tujuan")) {
    const url = e.target.getAttribute("data-url");

    Swal.fire({
        title: "Hapus Tujuan?",
        text: "Apakah kamu yakin ingin menghapus tujuan ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            if (url) {
                // Tujuan dari database
                fetch(url, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Tujuan berhasil dihapus!",
                            timer: 1200,
                            showConfirmButton: false
                        });
                        item.remove();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: data.message || "Terjadi kesalahan saat menghapus tujuan.",
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan",
                        text: "Terjadi error koneksi saat menghapus tujuan.",
                    });
                });
            } else {
                // Tujuan baru (belum di DB)
                item.remove();
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Tujuan berhasil dihapus!",
                    timer: 1200,
                    showConfirmButton: false
                });
            }
        }
    });
}

    });

// Simpan perubahan edit tujuan
// Simpan perubahan edit tujuan
document.getElementById("btnUpdateTujuan").addEventListener("click", function () {
    const newName = document.getElementById("editNamaTujuan").value.trim();
    if (!newName || !currentEditId) return;

    const editBtn = document.querySelector(`.edit-tujuan[data-id="${currentEditId}"]`);
    const item = editBtn?.closest(".tujuan-item");
    const checkbox = item?.querySelector("input[type=checkbox]");
    const label = item?.querySelector("label");

    // Kalau id bukan angka (belum di DB) → edit di client aja
    if (isNaN(currentEditId)) {
        if (checkbox) checkbox.value = newName;
        if (label) label.textContent = newName;
        editBtn.setAttribute("data-nama", newName);

        bootstrap.Modal.getInstance(document.getElementById("modalEditTujuan")).hide();
        currentEditId = null;
        return; // ⛔ stop di sini, jangan fetch ke server
    }

    // kalau id valid (dari DB), baru fetch
    fetch(`/form-perencanaan/mapa01/{{ $skema->id_skema }}/tujuan/${currentEditId}/update`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({ nama_tujuan: newName })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (checkbox) checkbox.value = newName;
            if (label) label.textContent = newName;
            editBtn.setAttribute("data-nama", newName);
            bootstrap.Modal.getInstance(document.getElementById("modalEditTujuan")).hide();
            currentEditId = null;
        } else {
            alert("Gagal update tujuan: " + (data.message ?? 'Unknown error'));
        }
    })
    .catch(() => alert("Terjadi error koneksi"));
});

 // klik emoji
    document.querySelectorAll(".emoji-option").forEach(el => {
        el.addEventListener("click", () => {
            const name = el.getAttribute("data-name");
            const value = el.getAttribute("data-value");

            // hapus active dari emoji lain di baris yang sama
            el.parentElement.querySelectorAll(".emoji-option").forEach(e => e.classList.remove("active"));
            el.classList.add("active");

            // cari atau buat hidden input
            let hiddenInput = document.querySelector(`#emoji-hidden-inputs input[name="hubungan_rating[${name}]"]`);
            if (!hiddenInput) {
                hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = `hubungan_rating[${name}]`;
                document.getElementById("emoji-hidden-inputs").appendChild(hiddenInput);
            }
            hiddenInput.value = value;
        });
    });

    // kontrol munculnya emoji berdasar checkbox
    document.querySelectorAll(".hubungan-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            const name = this.getAttribute("data-name");
            const emojiGroup = this.closest(".hubungan-item").querySelector(".emoji-group");

            if (this.checked) {
                emojiGroup.classList.remove("disabled");
            } else {
                emojiGroup.classList.add("disabled");
                // hapus pilihan emoji & nilai hidden input kalau uncheck
                emojiGroup.querySelectorAll(".emoji-option").forEach(e => e.classList.remove("active"));
                const hiddenInput = document.querySelector(`#emoji-hidden-inputs input[name="hubungan_rating[${name}]"]`);
                if (hiddenInput) hiddenInput.remove();
            }
        });
    });
});
</script>
@endsection