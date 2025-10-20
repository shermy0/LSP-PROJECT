@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center">FR.AK.02 – Rekaman Asesmen Kompetensi</h4>
    <p class="text-center text-muted">
        Skema Sertifikasi: <span class="fw-bold">{{ $skema->nama_skema }}</span>
    </p>

    <form action="{{ route('rekaman.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
        <input type="hidden" name="id_asesor" value="{{ Auth::id() }}">
        <input type="hidden" name="id_tuk" value="1"> {{-- TUK otomatis 1 --}}

        <!-- Data Asesmen -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <!-- Dropdown Asesi -->
                <div class="mb-3">
                    <label class="fw-bold">Pilih Nama Asesi</label>
                    <select name="id_asesi" class="form-control" required>
                        <option value="">-- Pilih Asesi --</option>
                        @foreach($asesis as $asesi)
                            <option value="{{ $asesi->id_asesi }}">{{ $asesi->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Asesmen -->
                <div class="mb-3">
                    <label class="fw-bold">Tanggal Asesmen</label>
                    <input type="date" name="tanggal_asesmen" class="form-control" required>
                </div>

            </div>
        </div>

        <!-- Tabel Unit Kompetensi -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p class="fw-bold">Keterangan Metode Asesmen:</p>
                <ul>
                    <li>OD = Observasi Demonstrasi</li>
                    <li>PPK = Pernyataan Pihak Ketiga</li>
                    <li>PW = Pertanyaan Wawancara</li>
                    <li>PL = Pertanyaan Lisan</li>
                    <li>PT = Pertanyaan Tertulis</li>
                    <li>PK = Proyek Kerja</li>
                    <li>L = Lainnya</li>
                </ul>

                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Unit Kompetensi</th>
                            <th>OD</th>
                            <th>PPK</th>
                            <th>PW</th>
                            <th>PL</th>
                            <th>PT</th>
                            <th>PK</th>
                            <th>L</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitKompetensi as $unit)
                        <tr>
                            <td class="text-start">
                                <input type="hidden" name="id_unit[]" value="{{ $unit->id_unit }}">
                                {{ $unit->judul_unit }}
                            </td>
                            <td><input type="checkbox" name="observasi[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="pernyataan_pihak_ketiga[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="pertanyaan_wawancara[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="pertanyaan_lisan[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="pertanyaan_tertulis[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="proyek_kerja[{{ $unit->id_unit }}]" value="1"></td>
                            <td><input type="checkbox" name="lainnya[{{ $unit->id_unit }}]" value="1"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rekomendasi & Komentar -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="mb-3">
    <label class="fw-bold">Rekomendasi Hasil Asesmen</label><br>
    <label class="form-check form-check-inline">
    <input type="radio" name="rekomendasi" value="K" class="form-check-input"required> K (Kompeten)
</label>
<label class="form-check form-check-inline">
    <input type="radio" name="rekomendasi" value="BK" class="form-check-input"required> BK (Belum Kompeten)
</label>

</div>


                <div class="mb-3">
                    <label class="fw-bold">Tindak lanjut yang dibutuhkan</label>
                    <textarea name="tindak_lanjut" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Komentar / Observasi Asesor</label>
                    <textarea name="komentar" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary fw-bold px-4">Simpan Rekaman Asesmen</button>
        </div>
    </form>
</div>
@endsection
