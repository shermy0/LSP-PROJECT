@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center">FR.IA.07 – Lembar Pertanyaan Lisan</h4>
    <p class="text-center text-muted">Skema: <span class="fw-bold">{{ $skema->nama_skema }}</span></p>

    <form id="formPertanyaanLisan" action="{{ route('pertanyaan.lisan.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
    <input type="hidden" name="id_asesor" value="1">

    <!-- Tambahan hidden input -->
    <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $idPembuatanPertanyaan }}">
    <input type="hidden" name="id_kelompok" value="{{ $idKelompok }}">


        <!-- Daftar pertanyaan -->
        <div id="daftarPertanyaanLisan">
            @for ($i = 1; $i <= $jumlah; $i++)
            <div class="card mb-3 shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pertanyaan {{ $i }}</label>
                        <textarea name="isi_pertanyaan[]" class="form-control rounded-3" rows="2"
                            placeholder="Masukkan pertanyaan lisan ke-{{ $i }}" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kunci Jawaban</label>
                        <input type="text" name="kunci_jawaban[]" class="form-control rounded-3"
                            placeholder="Masukkan kunci jawaban">
                    </div>
               </div>
            </div>
            @endfor
        </div>

        <!-- Tombol simpan -->
        <div class="text-center mt-4">
            <button type="button" class="btn px-4 fw-bold text-white"
                style="background-color:#041562;" onclick="konfirmasiSimpan()">
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
let totalPertanyaan = {{ $jumlah }};

// Fungsi popup konfirmasi
function konfirmasiSimpan() {
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        html: '<p class="mb-0">Pilih <b>Simpan</b> untuk menyimpan atau <b>Tambah</b> untuk menambahkan pertanyaan baru.</p>',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="bi bi-save"></i> Simpan',
        denyButtonText: '<i class="bi bi-plus-circle"></i> Tambah Pertanyaan',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-4 shadow-lg p-4',
            confirmButton: 'btn text-white fw-bold px-4 py-2 me-2',
            denyButton: 'btn text-white fw-bold px-4 py-2',
        },
        didRender: () => {
            let confirmBtn = document.querySelector('.swal2-confirm');
            let denyBtn = document.querySelector('.swal2-deny');
            if (confirmBtn) confirmBtn.style.backgroundColor = '#041562';
            if (denyBtn) denyBtn.style.backgroundColor = '#28a745';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPertanyaanLisan').submit();
        } else if (result.isDenied) {
            tambahPertanyaanPopup();
        }
    });
}

// Popup input jumlah pertanyaan tambahan
function tambahPertanyaanPopup() {
    Swal.fire({
        title: '<h6 class="fw-bold mb-3">Jumlah Pertanyaan Baru :</h6>',
        html: `
            <input id="jumlahPertanyaan" type="number" class="form-control text-center mb-2" 
                   min="1" max="15" value="1">
            <small class="text-danger d-block mb-3">Maksimal 15 pertanyaan</small>
            <button type="button" id="btnTambahPertanyaan" 
                class="btn w-100 fw-bold text-white" style="background-color:#041562;">Tambah</button>
        `,
        showConfirmButton: false,
        allowOutsideClick: false,
        customClass: {
            popup: 'rounded-4 shadow-lg p-4',
        },
        didRender: () => {
            document.getElementById('btnTambahPertanyaan').addEventListener('click', () => {
                let jumlah = parseInt(document.getElementById('jumlahPertanyaan').value);
                if (isNaN(jumlah) || jumlah < 1) {
                    Swal.fire('Error', 'Minimal 1 pertanyaan', 'error'); return;
                }
                if (jumlah > 15) {
                    Swal.fire('Error', 'Maksimal 15 pertanyaan', 'error'); return;
                }
                Swal.close();
                tambahPertanyaan(jumlah);
            });
        }
    });
}

// Tambah pertanyaan baru
function tambahPertanyaan(jumlahBaru) {
    for (let j = 1; j <= jumlahBaru; j++) {
        totalPertanyaan++;
        let div = document.createElement('div');
        div.classList.add('card', 'mb-3', 'shadow-sm', 'border-0', 'rounded-4');
        div.innerHTML = `
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Pertanyaan ${totalPertanyaan}</label>
                    <textarea name="isi_pertanyaan[]" class="form-control rounded-3" rows="2"
                        placeholder="Masukkan pertanyaan lisan ke-${totalPertanyaan}" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kunci Jawaban</label>
                    <input type="text" name="kunci_jawaban[]" class="form-control rounded-3"
                        placeholder="Masukkan kunci jawaban">
                </div>
            </div>
        `;
        document.getElementById('daftarPertanyaanLisan').appendChild(div);
    }
}
</script>
@endsection
