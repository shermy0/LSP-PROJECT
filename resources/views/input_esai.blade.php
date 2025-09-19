@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Input Pertanyaan Esai</h4>
    <p class="text-muted">Jumlah soal yang dipilih: {{ $jumlah }}</p>

   <form id="formPertanyaan" action="{{ route('pertanyaan.esai.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
    <input type="hidden" name="id_asesor" value="1">
    <input type="hidden" name="timer" value="{{ request('timer', 30) }}"> <!-- dari GET modal -->
    <input type="hidden" name="id_kelompok" value="{{ request('kelompok_id') }}"> <!-- ✅ ditambahin -->

    <div id="daftarPertanyaan">
        @for ($i = 1; $i <= $jumlah; $i++)
        <div class="card mb-3 shadow-sm pertanyaan-item">
            <div class="card-body">
                <h6 class="fw-bold">Pertanyaan {{ $i }}</h6>

                <input type="file" name="file[]" class="form-control mb-2"
                    accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">

                <textarea name="isi_pertanyaan[]" class="form-control mb-2"
                    placeholder="Masukkan pertanyaan ke-{{ $i }}" required></textarea>

                <input type="text" name="kunci_jawaban[]" class="form-control"
                    placeholder="Kunci jawaban">
            </div>
        </div>
        @endfor
    </div>

    <button type="submit" class="btn btn-success">Simpan Semua Pertanyaan</button>
</form>

</div>

<script>
let totalPertanyaan = {{ $jumlah }};

function konfirmasiSimpan() {
    let konfirmasi = confirm("Apakah anda sudah yakin?");
    if (konfirmasi) {
        document.getElementById('formPertanyaan').submit();
    } else {
        tambahPertanyaan();
    }
}

function tambahPertanyaan() {
    totalPertanyaan++;

    let div = document.createElement('div');
    div.classList.add('card', 'mb-3', 'shadow-sm', 'pertanyaan-item');
    div.innerHTML = `
        <div class="card-body">
            <h6 class="fw-bold">Pertanyaan ${totalPertanyaan}</h6>

            <input type="file" name="file[]" class="form-control mb-2"
                accept=".jpg,.jpeg,.png,.pdf,.docx,.mp3,.mp4">
            <small class="text-muted">Bisa upload gambar, PDF, Word, audio, atau video (max 5MB)</small>

            <textarea name="isi_pertanyaan[]" class="form-control mb-2"
                placeholder="Masukkan pertanyaan ke-${totalPertanyaan}" required></textarea>

            <input type="text" name="kunci_jawaban[]" class="form-control"
                placeholder="Kunci jawaban">
        </div>
    `;

    document.getElementById('daftarPertanyaan').appendChild(div);
}
</script>
@endsection
