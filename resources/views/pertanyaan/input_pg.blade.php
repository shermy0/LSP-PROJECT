@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Input Pertanyaan Pilihan Ganda</h4>
    <p class="text-muted">Jumlah soal yang dipilih: {{ $jumlah }}</p>

    <form action="{{ route('pertanyaan.pg.store') }}" method="POST" enctype="multipart/form-data" id="formPG">
        @csrf

        <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
        <input type="hidden" name="id_kelompok" value="{{ $kelompok->id_kelompok }}">
        <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $id_pembuatan_pertanyaan }}">
        <input type="hidden" name="timer" value="{{ $timer }}">

        @for ($i = 0; $i < $jumlah; $i++)
            <div class="card mb-4 pertanyaan-item">
                <div class="card-header bg-light">
                    <h5 class="fw-bold mb-0">Pertanyaan {{ $i + 1 }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Isi Pertanyaan</label>
                        <textarea name="isi_pertanyaan[{{ $i }}]" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Pendukung Pertanyaan (opsional)</label>
                        <input type="file" 
                            name="file[{{ $i }}]" 
                            class="form-control file-pertanyaan"
                            accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4"
                            data-index="{{ $i }}">

                        <div class="preview-pertanyaan mt-2 d-none">
                            <img src="" class="img-thumbnail" style="max-height:150px;">
                        </div>                    
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Opsi Jawaban</label>
                        
                        @foreach (['A','B','C','D','E'] as $j => $kode)
                            <div class="opsi-item mb-3 p-3 border rounded">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <span class="badge bg-primary fs-6">Opsi {{ $kode }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="jenis_opsi[{{ $i }}][{{ $j }}]" class="form-select jenis-opsi" data-pertanyaan="{{ $i }}" data-opsi="{{ $j }}">
                                            <option value="text">Teks</option>
                                            <option value="gambar">Gambar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <!-- Input Teks -->
                                        <div class="opsi-text">
                                            <input type="text" 
                                                   name="opsi_text[{{ $i }}][{{ $j }}]" 
                                                   class="form-control" 
                                                   placeholder="Isi teks untuk opsi {{ $kode }}">
                                        </div>
                                        
                                        <!-- Input Gambar -->
                                        <div class="opsi-gambar d-none">
                                            <input type="file" 
                                                   name="opsi_gambar[{{ $i }}][{{ $j }}]" 
                                                   class="form-control opsi-gambar-input" 
                                                   accept=".jpg,.jpeg,.png"
                                                   data-pertanyaan="{{ $i }}"
                                                   data-opsi="{{ $j }}">
                                            <small class="text-muted">Format: JPG, JPEG, PNG (max 2MB)</small>
                                            <div class="image-preview mt-2 d-none">
                                                <img src="" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kunci Jawaban</label>
                        <select name="kunci_jawaban[{{ $i }}]" class="form-select" required>
                            <option value="">-- Pilih Kunci Jawaban --</option>
                            @foreach (['A','B','C','D','E'] as $kode)
                                <option value="{{ $kode }}">{{ $kode }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endfor

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Semua Pertanyaan</button>
            <a href="{{ route('pg.crud', ['id_skema' => $skema->id_skema, 'id_kelompok' => $kelompok->id_kelompok]) }}" 
               class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<style>
.opsi-item {
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}
.opsi-item:hover {
    background-color: #e9ecef;
}
.image-preview img {
    max-width: 100%;
    height: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk toggle antara teks dan gambar
    function toggleJenisOpsi(selectElement) {
        const pertanyaanIndex = selectElement.dataset.pertanyaan;
        const opsiIndex = selectElement.dataset.opsi;
        const jenis = selectElement.value;
        
        const opsiItem = selectElement.closest('.opsi-item');
        const opsiText = opsiItem.querySelector('.opsi-text');
        const opsiGambar = opsiItem.querySelector('.opsi-gambar');
        
        if (jenis === 'text') {
            opsiText.classList.remove('d-none');
            opsiGambar.classList.add('d-none');
            // Reset file input ketika beralih ke teks
            opsiGambar.querySelector('input[type="file"]').value = '';
            opsiGambar.querySelector('.image-preview').classList.add('d-none');
        } else {
            opsiText.classList.add('d-none');
            opsiGambar.classList.remove('d-none');
            // Reset text input ketika beralih ke gambar
            opsiText.querySelector('input[type="text"]').value = '';
        }
    }
    
    // Fungsi untuk preview gambar
    function previewImage(input) {
        const preview = input.closest('.opsi-gambar').querySelector('.image-preview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('d-none');
            img.src = '';
        }
    }
    
    // Event listener untuk semua select jenis opsi
    document.querySelectorAll('.jenis-opsi').forEach(select => {
        // Set initial state
        toggleJenisOpsi(select);
        
        // Add change event
        select.addEventListener('change', function() {
            toggleJenisOpsi(this);
        });
    });
    
    // Event listener untuk preview gambar
    document.querySelectorAll('.opsi-gambar-input').forEach(input => {
        input.addEventListener('change', function() {
            previewImage(this);
        });
    });
    
    // Validasi form sebelum submit
    document.getElementById('formPG').addEventListener('submit', function(e) {
        let isValid = true;
        const errorMessages = [];
        
        // Validasi setiap pertanyaan
        document.querySelectorAll('.pertanyaan-item').forEach((pertanyaan, i) => {
            const textarea = pertanyaan.querySelector('textarea[name^="isi_pertanyaan"]');
            const kunciJawaban = pertanyaan.querySelector('select[name^="kunci_jawaban"]');
            
            // Validasi isi pertanyaan
            if (!textarea.value.trim()) {
                isValid = false;
                errorMessages.push(`Pertanyaan ${i + 1}: Isi pertanyaan harus diisi`);
            }
            
            // Validasi kunci jawaban
            if (!kunciJawaban.value) {
                isValid = false;
                errorMessages.push(`Pertanyaan ${i + 1}: Pilih kunci jawaban`);
            }
            
            // Validasi opsi
            const opsiItems = pertanyaan.querySelectorAll('.opsi-item');
            opsiItems.forEach((opsi, j) => {
                const jenis = opsi.querySelector('.jenis-opsi').value;
                const kode = ['A','B','C','D','E'][j];
                
                if (jenis === 'text') {
                    const textInput = opsi.querySelector('input[type="text"]');
                    if (!textInput.value.trim()) {
                        isValid = false;
                        errorMessages.push(`Pertanyaan ${i + 1} Opsi ${kode}: Teks opsi harus diisi`);
                    }
                } else if (jenis === 'gambar') {
                    const fileInput = opsi.querySelector('input[type="file"]');
                    if (!fileInput.files.length) {
                        isValid = false;
                        errorMessages.push(`Pertanyaan ${i + 1} Opsi ${kode}: File gambar harus dipilih`);
                    }
                }
            });
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Terjadi kesalahan:\n' + errorMessages.join('\n'));
        }
    });
});

// Preview gambar untuk file pertanyaan
document.querySelectorAll('.file-pertanyaan').forEach(input => {

input.addEventListener('change', function(){

    const file = this.files[0];
    const preview = this.parentElement.querySelector('.preview-pertanyaan');
    const img = preview.querySelector('img');

    if(!file){
        preview.classList.add('d-none');
        return;
    }

    // cek apakah gambar
    if(file.type.startsWith('image/')){

        const reader = new FileReader();

        reader.onload = function(e){
            img.src = e.target.result;
            preview.classList.remove('d-none');
        }

        reader.readAsDataURL(file);

    }else{
        preview.classList.add('d-none');
    }

});

});

</script>
@endsection