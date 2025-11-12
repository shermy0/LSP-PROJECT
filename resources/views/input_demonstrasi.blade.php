@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center">FR.IA.02 – Input Pertanyaan Demonstrasi</h4>
    <p class="text-center text-muted">Skema: <span class="fw-bold">{{ $skema->nama_skema }}</span></p>
    <p class="text-center text-muted small">Jumlah Pertanyaan: {{ $jumlah }} | Timer: {{ $timer }} menit</p>

    <form id="formPertanyaanDemo" action="{{ route('demonstrasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
        <input type="hidden" name="id_asesor" value="{{ auth()->id() ?? 1 }}">
        <input type="hidden" name="timer" value="{{ $timer }}">

        <!-- Daftar pertanyaan -->
        <div id="daftarPertanyaanDemo">
            @for ($i = 1; $i <= $jumlah; $i++)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold">Instruksi / Pertanyaan {{ $i }}</label>
                        <textarea name="instruksi[]" class="form-control"
                            placeholder="Tulis instruksi tugas ke-{{ $i }}" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Lampiran (opsional)</label>
                        <input type="file" name="file[]" class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <!-- Tombol simpan -->
        <div class="text-center mt-4">
            <button type="button" class="btn px-4" 
                    style="background-color:#041562; color:#fff; font-weight:bold;" 
                    onclick="konfirmasiSimpanDemo()">Simpan</button>
        </div>
    </form>
</div>

<script>
let totalPertanyaanDemo = {{ $jumlah }};

// Konfirmasi simpan / tambah
function konfirmasiSimpanDemo() {
    Swal.fire({
        title: 'Apakah Anda Yakin?',
        html: '<p class="mb-0">Pilih <b>Simpan</b> untuk menyimpan atau <b>Tambah</b> untuk menambahkan instruksi baru.</p>',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: '<i class="bi bi-save"></i> Simpan',
        denyButtonText: '<i class="bi bi-plus-circle"></i> Tambah Instruksi',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-4 shadow-lg p-4',
            title: 'fw-bold fs-5 mb-2',
            confirmButton: 'btn text-white fw-bold px-4 py-2 me-2',
            denyButton: 'btn text-white fw-bold px-4 py-2',
        },
        didRender: () => {
            let confirmBtn = document.querySelector('.swal2-confirm');
            let denyBtn = document.querySelector('.swal2-deny');

            if (confirmBtn) {
                confirmBtn.style.backgroundColor = '#041562';
                confirmBtn.style.cursor = 'pointer';
            }
            if (denyBtn) {
                denyBtn.style.backgroundColor = '#28a745';
                denyBtn.style.cursor = 'pointer';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPertanyaanDemo').submit();
        } else if (result.isDenied) {
            Swal.fire({
                title: '<h6 class="fw-bold mb-3">Ketik Jumlah Instruksi :</h6>',
                html: `
                    <input id="jumlahInstruksi" type="number" class="form-control mb-2 text-center" 
                           min="1" max="15" value="1">
                    <small class="text-danger d-block mb-3">note: maksimal 15 instruksi</small>
                    <button type="button" id="btnTambahInstruksi" 
                        class="btn w-100 fw-bold text-white" 
                        style="background-color:#041562; cursor:pointer;">Tambah</button>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg p-4',
                    title: 'fw-bold fs-5 mb-2',
                },
                didRender: () => {
                    document.getElementById('btnTambahInstruksi').addEventListener('click', () => {
                        let jumlah = parseInt(document.getElementById('jumlahInstruksi').value);

                        if (isNaN(jumlah) || jumlah < 1) {
                            Swal.fire('Error', 'Minimal 1 instruksi', 'error');
                            return;
                        }
                        if (jumlah > 15) {
                            Swal.fire('Error', 'Maksimal 15 instruksi', 'error');
                            return;
                        }

                        Swal.close();
                        tambahInstruksi(jumlah);
                    });
                }
            });
        }
    });
}

// Tambah instruksi baru
function tambahInstruksi(jumlahBaru) {
    for (let j = 1; j <= jumlahBaru; j++) {
        totalPertanyaanDemo++;

        let div = document.createElement('div');
        div.classList.add('card', 'mb-3', 'shadow-sm');
        div.innerHTML = `
            <div class="card-body">
                <div class="mb-3">
                    <label class="fw-bold">Instruksi / Pertanyaan ${totalPertanyaanDemo}</label>
                    <textarea name="instruksi[]" class="form-control"
                        placeholder="Tulis instruksi tugas ke-${totalPertanyaanDemo}" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Lampiran (opsional)</label>
                    <input type="file" name="file[]" class="form-control"
                        accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                </div>
            </div>
        `;
        document.getElementById('daftarPertanyaanDemo').appendChild(div);
    }
}
</script>
@endsection
