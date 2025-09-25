@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Pilihan Ganda</h4>

    <form id="formPertanyaan" action="{{ route('pertanyaan.pg.update', $pertanyaan->id_pertanyaan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
        <input type="hidden" name="id_kelompok" value="{{ $pertanyaan->id_kelompok }}">

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="fw-bold mb-0">Edit Pertanyaan</h6>
            </div>
            <div class="card-body">
                <!-- File Upload -->
                <div class="mb-3">
                    <label class="form-label">Lampiran (Opsional)</label>
                    @if($pertanyaan->file_path)
                        <div class="mb-2">
                            <strong>File saat ini:</strong>
                            <a href="{{ asset('storage/'.$pertanyaan->file_path) }}" target="_blank" class="ms-2">
                                Lihat File
                            </a>
                            <br>
                            <small class="text-muted">
                                <input type="checkbox" name="hapus_file" id="hapus_file">
                                <label for="hapus_file">Hapus file saat ini</label>
                            </small>
                        </div>
                    @endif
                    <input type="file" name="file" class="form-control"
                        accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
                    <small class="text-muted">Bisa upload gambar, PDF, Word, audio, atau video (max 5MB)</small>
                </div>

                <!-- Pertanyaan -->
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="isi_pertanyaan" class="form-control" 
                        placeholder="Masukkan pertanyaan" required rows="3">{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>
                </div>

                <!-- Opsi Jawaban -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Opsi Jawaban</label>
                    
                    <div class="row" id="daftar-opsi">
                    @php
                        $opsiData = [];
                        foreach($pertanyaan->opsiJawaban as $opsi) {
                            $opsiData[$opsi->kode_opsi] = $opsi->isi_opsi;
                        }
                        
                        // Default opsi yang akan ditampilkan
                        $defaultOpsi = ['A', 'B', 'C', 'D', 'E'];
                        $jumlahOpsiAktif = max(count($pertanyaan->opsiJawaban), 5);
                    @endphp

                    @for($i = 0; $i < $jumlahOpsiAktif; $i++)
                        @php $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'][$i] ?? 'A'; @endphp
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text">{{ $huruf }}</span>
                                <input type="text" name="opsi[]" 
                                    class="form-control opsi-input" 
                                    placeholder="Opsi {{ $huruf }}" 
                                    value="{{ old('opsi.'.$i, $opsiData[$huruf] ?? '') }}"
                                    data-kode="{{ $huruf }}">
                                    
                                <!-- Radio button untuk kunci jawaban -->
                                <div class="input-group-text">
                                    <div class="form-check">
                                        <input class="form-check-input kunci-radio" 
                                            type="radio" 
                                            name="kunci_jawaban" 
                                            value="{{ $huruf }}"
                                            {{ ($pertanyaan->kunci_jawaban == $huruf) ? 'checked' : '' }}
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                    <!-- Tombol tambah/hapus opsi -->
                    <!-- <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="tambahOpsi()">
                            <i class="fas fa-plus"></i> Tambah Opsi
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusOpsi()">
                            <i class="fas fa-minus"></i> Hapus Opsi
                        </button>
                        <small class="text-muted ms-2">Minimal 2 opsi, maksimal 10 opsi</small>
                    </div> -->
                </div>

                <!-- Kunci Jawaban (Display Only) -->
                <div class="mb-3">
                    <label class="form-label">Kunci Jawaban Terpilih</label>
                    <div class="alert alert-info py-2">
                        <strong id="kunci-display">{{ $pertanyaan->kunci_jawaban }}</strong>
                        <span id="teks-opsi-benar">
                            @foreach($pertanyaan->opsiJawaban as $opsi)
                                @if($opsi->benar)
                                    - {{ $opsi->isi_opsi }}
                                @endif
                            @endforeach
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('pg.crud', ['id_skema' => $pertanyaan->id_skema, 'id_kelompok' => $pertanyaan->id_kelompok]) }}" 
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Update Pertanyaan
            </button>
        </div>
    </form>
</div>

<script>
// Data opsi yang tersedia
const semuaOpsi = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
let opsiAktif = 5; // Default A-E

function updateKunciDisplay() {
    const radioTerpilih = document.querySelector('input[name="kunci_jawaban"]:checked');
    if (radioTerpilih) {
        const kode = radioTerpilih.value;
        const inputOpsi = document.querySelector(`.opsi-input[data-kode="${kode}"]`);
        const teksOpsi = inputOpsi ? inputOpsi.value : '';
        
        document.getElementById('kunci-display').textContent = kode;
        document.getElementById('teks-opsi-benar').textContent = teksOpsi ? `- ${teksOpsi}` : '';
    }
}

function tambahOpsi() {
    if (opsiAktif >= 10) {
        alert('Maksimal 10 opsi');
        return;
    }

    const kodeBaru = semuaOpsi[opsiAktif];
    const divOpsi = document.getElementById('daftar-opsi');
    
    const colDiv = document.createElement('div');
    colDiv.className = 'col-md-6 mb-2';
    colDiv.innerHTML = `
        <div class="input-group">
            <span class="input-group-text">${kodeBaru}</span>
            <input type="text" name="opsi[]" 
                class="form-control opsi-input" 
                placeholder="Opsi ${kodeBaru}"
                data-kode="${kodeBaru}">
                
            <div class="input-group-text">
                <div class="form-check">
                    <input class="form-check-input kunci-radio" 
                        type="radio" 
                        name="kunci_jawaban" 
                        value="${kodeBaru}">
                </div>
            </div>
        </div>
    `;

    divOpsi.appendChild(colDiv);
    opsiAktif++;

    // Attach event listener to new radio
    const newRadio = colDiv.querySelector('.kunci-radio');
    newRadio.addEventListener('change', updateKunciDisplay);
}

function hapusOpsi() {
    if (opsiAktif <= 2) {
        alert('Minimal 2 opsi');
        return;
    }

    const divOpsi = document.getElementById('daftar-opsi');
    const lastOpsi = divOpsi.lastElementChild;
    
    // Cek jika opsi yang akan dihapus adalah kunci jawaban
    const radioOpsi = lastOpsi.querySelector('.kunci-radio');
    if (radioOpsi.checked) {
        alert('Tidak bisa menghapus opsi yang merupakan kunci jawaban. Silakan pilih kunci jawaban lain terlebih dahulu.');
        return;
    }

    divOpsi.removeChild(lastOpsi);
    opsiAktif--;
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Attach event listeners to existing radios
    document.querySelectorAll('.kunci-radio').forEach(radio => {
        radio.addEventListener('change', updateKunciDisplay);
    });

    // Attach event listeners to opsi inputs
    document.querySelectorAll('.opsi-input').forEach(input => {
        input.addEventListener('input', function() {
            const radioTerpilih = document.querySelector('input[name="kunci_jawaban"]:checked');
            if (radioTerpilih && radioTerpilih.value === this.dataset.kode) {
                updateKunciDisplay();
            }
        });
    });

    // Validasi form sebelum submit
    document.getElementById('formPertanyaan').addEventListener('submit', function(e) {
        const opsiTerisi = Array.from(document.querySelectorAll('.opsi-input'))
            .filter(input => input.value.trim() !== '').length;
        
        if (opsiTerisi < 2) {
            e.preventDefault();
            alert('Minimal harus ada 2 opsi jawaban yang diisi');
            return;
        }

        const kunciTerpilih = document.querySelector('input[name="kunci_jawaban"]:checked');
        if (!kunciTerpilih) {
            e.preventDefault();
            alert('Harap pilih kunci jawaban');
            return;
        }

        // Validasi opsi kunci jawaban harus terisi
        const kodeKunci = kunciTerpilih.value;
        const inputKunci = document.querySelector(`.opsi-input[data-kode="${kodeKunci}"]`);
        if (!inputKunci || inputKunci.value.trim() === '') {
            e.preventDefault();
            alert('Opsi yang dipilih sebagai kunci jawaban harus diisi');
            return;
        }
    });
});

// Initial display update
updateKunciDisplay();
</script>

<style>
.kunci-radio:checked {
    background-color: #198754;
    border-color: #198754;
}

.input-group-text {
    background-color: #f8f9fa;
}

.opsi-input:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>
@endsection