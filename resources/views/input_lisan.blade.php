@extends('master')

@section('konten')
<div class="container mt-4">
    @if(isset($pertanyaan))
        <h4 class="fw-bold">FR.IA.07 – Edit Pertanyaan Lisan</h4>

        <form id="formEditPertanyaan" action="{{ route('lisan.update', $pertanyaan->id_pertanyaan) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_skema" value="{{ $pertanyaan->id_skema }}">
            <input type="hidden" name="id_asesor" value="{{ $pertanyaan->id_asesor }}">
            <input type="hidden" name="id_kelompok" value="{{ $pertanyaan->id_kelompok }}">
            <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $pertanyaan->id_pembuatan_pertanyaan }}">

            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">Pertanyaan</h6>
                    <textarea name="isi_pertanyaan" class="form-control mb-2" rows="2" required>{{ old('isi_pertanyaan', $pertanyaan->isi_pertanyaan) }}</textarea>

                    <h6 class="fw-bold mt-3">Kunci Jawaban</h6>
                    <input type="text" name="kunci_jawaban" class="form-control"
                        value="{{ old('kunci_jawaban', $pertanyaan->kunci_jawaban) }}" placeholder="Kunci jawaban">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('lisan.crud', $pertanyaan->id_skema) }}" class="btn btn-secondary">Batal</a>
            {{-- 🔽 Tambahan tombol simpan & kembali --}}
            <a href="{{ route('kelompok.lisan.index', $pertanyaan->id_skema) }}" class="btn btn-primary">
                Simpan & Kembali
            </a>
        </form>

    @else
        <h4 class="fw-bold text-center">FR.IA.07 – Lembar Pertanyaan Lisan</h4>
        <p class="text-center text-muted">Skema: <span class="fw-bold">{{ $skema->nama_skema ?? '-' }}</span></p>

        <form id="formPertanyaanLisan" action="{{ route('lisan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_skema" value="{{ $skema->id_skema ?? ($id_skema ?? '') }}">
            <input type="hidden" name="id_asesor" value="{{ $id_asesor ?? 1 }}">
            <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $idPembuatanPertanyaan ?? '' }}">
            <input type="hidden" name="id_kelompok" value="{{ $idKelompok ?? '' }}">

            <div id="daftarPertanyaanLisan">
                @for ($i = 1; $i <= ($jumlah ?? 5); $i++)
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

            <div class="text-center mt-4 d-flex gap-2 justify-content-center">
                <button type="submit" class="btn px-4 fw-bold text-white" style="background-color:#041562;">
                    Simpan
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
