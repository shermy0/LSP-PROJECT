@extends('master')

@section('konten')
<div class="container mt-4">
<form action="{{ route('pmo.store', ['id_pmo' => $id_pmo]) }}" method="POST">

    @csrf
    <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
    <input type="hidden" name="id_kelompok" value="{{ $kelompok->id_kelompok }}">
    <input type="hidden" name="timer" value="{{ $timer ?? 30 }}">

        @foreach($kelompok->unitKompetensi as $unit)
            <input type="hidden" name="id_unit[]" value="{{ $unit->id_unit }}">
            <div class="card mb-4 shadow-sm">
                <div class="card-header" style="background-color:#041562; color:white; font-weight:bold;">
                    Evaluasi Unit: {{ $unit->judul_unit ?? $unit->kode_unit }}
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Skema: <span class="fw-bold">{{ $skema->nama_skema }}</span> |
                        Timer: <span class="fw-bold">{{ $timer ?? '-' }} menit</span> |
                        Kelompok: <span class="fw-bold">{{ $kelompok->nama_kelompok }}</span>
                    </p>

                    <div id="daftarPertanyaanPMO{{ $unit->id_unit }}">
                        @for($i = 1; $i <= ($jumlah ?? 5); $i++)
                        <div class="card mb-3 shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pertanyaan {{ $i }}</label>
                                    <textarea name="pertanyaan[{{ $unit->id_unit }}][]" 
                                        class="form-control rounded-3" rows="2"
                                        placeholder="Masukkan pertanyaan ke-{{ $i }}" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi / Petunjuk (Opsional)</label>
                                    <textarea name="deskripsi_pertanyaan[{{ $unit->id_unit }}][]" 
                                        class="form-control rounded-3" rows="2"
                                        placeholder="Opsional: deskripsi atau petunjuk"></textarea>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>

                    <div class="text-end mt-2">
                        <button type="button" 
                                class="btn btn-sm btn-outline-primary tambah-pertanyaan" 
                                data-unit="{{ $unit->id_unit }}">
                            + Tambah Pertanyaan
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-center mt-4 d-flex gap-2 justify-content-center">
            <button type="submit" 
                    class="btn px-4 fw-bold text-white" 
                    style="background-color:#041562; border-radius:8px; padding:0.5rem 1.5rem;">
                Simpan Semua Pertanyaan PMO
            </button>
            <a href="{{ route('formasesmen.pmo', $skema->id_skema) }}" 
            class="btn btn-secondary px-4 fw-bold" 
            style="border-radius:8px; padding:0.5rem 1.5rem;">
                Batal / Kembali
            </a>
        </div>
    </form>
</div>

<script>
function tambahPertanyaan(unitId){
    let daftar = document.getElementById('daftarPertanyaanPMO' + unitId);
    let count = daftar.querySelectorAll('.card').length + 1;

    let newCard = document.createElement('div');
    newCard.classList.add('card','mb-3','shadow-sm','border-0','rounded-4');
    newCard.innerHTML = `
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Pertanyaan ${count}</label>
                <textarea name="pertanyaan[${unitId}][]" class="form-control rounded-3" rows="2"
                    placeholder="Masukkan pertanyaan ke-${count}" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi / Petunjuk (Opsional)</label>
                <textarea name="deskripsi_pertanyaan[${unitId}][]" class="form-control rounded-3" rows="2"
                    placeholder="Opsional: deskripsi atau petunjuk"></textarea>
            </div>
        </div>
    `;
    daftar.appendChild(newCard);
}

document.querySelectorAll('.tambah-pertanyaan').forEach(btn => {
    btn.addEventListener('click', function(){
        tambahPertanyaan(this.dataset.unit);
    });
});
</script>
@endsection
