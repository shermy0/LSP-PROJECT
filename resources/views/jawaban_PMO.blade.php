@extends('master')
@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="text-center mb-4">
                <h5 class="fw-bold mb-1" style="color:#041562;">
                    Evaluasi Penerapan Standar Operasional
                </h5>
                <h6 class="fw-semibold mb-2" style="color:#041562;">
                    {{ $skema->nama_skema }}
                </h6>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @foreach($kelompok as $k)
                        <span class="badge rounded-pill px-3 py-2" style="background-color:#e8edf8; color:#041562; font-size:0.8rem;">
                            <i class="bi bi-briefcase me-1"></i>{{ $k->nama_kelompok }}
                        </span>
                    @endforeach
                </div>
            </div>

            <hr class="mb-4">

            <form action="{{ route('jawaban.pmo.simpan', [$skema->id_skema, $pembuatan->id_pembuatan_pertanyaan]) }}" method="POST">
                @csrf
                <table class="table table-bordered align-middle">
                    <thead class="text-center" style="background-color:#041562; color:white;">
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 55%;">Pertanyaan</th>
                            <th style="width: 40%;">Tanggapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pertanyaan as $i => $p)
                        <tr>
                            <td class="text-center fw-bold">{{ $i+1 }}</td>
                            <td>{{ $p->pertanyaan }}</td>
                            <td>
                                <textarea name="jawaban[{{ $p->id_pmo_pertanyaan }}]"
                                    class="form-control rounded-3" rows="2"
                                    placeholder="Tanggapan...">{{ old('jawaban.'.$p->id_pmo_pertanyaan, $p->jawaban ?? '') }}</textarea>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                Belum ada pertanyaan untuk PMO ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Tombol kiri-kanan --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('formasesmen.pmo', ['id_skema' => $skema->id_skema]) }}"
                       class="btn btn-secondary fw-bold px-4 rounded-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn px-5 fw-bold text-white rounded-3" style="background-color:#041562;">
                        <i class="bi bi-save me-2"></i>Simpan Jawaban
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection