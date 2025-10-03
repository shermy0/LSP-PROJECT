@extends('master')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h5 class="fw-bold text-center mb-4">Evaluasi Penerapan Standar Operasional Proyek Multimedia</h5>

            <form action="{{ route('jawaban.pmo.simpan', [$skema->id_skema, $pembuatan->id_pembuatan_pertanyaan]) }}" method="POST">
                @csrf

                <table class="table table-bordered align-middle">
                    <thead class="text-center table-light">
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
                            <td colspan="3" class="text-center text-danger">
                                Belum ada pertanyaan untuk PMO ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <button type="submit" class="btn px-4 fw-bold text-white" style="background-color:#041562;">
                        Simpan Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
