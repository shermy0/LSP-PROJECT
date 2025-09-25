@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Daftar Pertanyaan Pilihan Ganda</h4>

    @foreach($pertanyaan as $index => $p)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="fw-bold mb-0">{{ $index+1 }}. Pertanyaan Pilihan Ganda</h6>
            </div>
            <div class="card-body">
                <!-- Pertanyaan -->
                <h6 class="fw-bold">Pertanyaan:</h6>
                <p>{{ $p->isi_pertanyaan }}</p>

                <!-- File Lampiran -->
                @if($p->file_path)
                    <p><strong>Lampiran:</strong> 
                        <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat File</a>
                    </p>

                    @if(in_array($p->file_type, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$p->file_path) }}" alt="Gambar Pertanyaan" class="img-fluid mb-2" style="max-width:200px;">
                    @endif
                @endif

                <!-- Opsi Jawaban -->
                <h6 class="fw-bold mt-3">Opsi Jawaban:</h6>
                <div class="row">
                    @foreach($p->opsiJawaban as $opsi)
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <span class="input-group-text {{ $opsi->benar ? 'bg-success text-white' : '' }}">
                                    {{ $opsi->kode_opsi }}
                                </span>
                                <input type="text" class="form-control" value="{{ $opsi->isi_opsi }}" readonly>
                                @if($opsi->benar)
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Kunci Jawaban -->
                <p class="text-primary mt-2">
                    <strong>Kunci Jawaban:</strong> {{ $p->kunci_jawaban }}
                </p>

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <a href="{{ route('pertanyaan.pg.edit', $p->id_pertanyaan) }}" 
                       class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    
                    <form action="{{ route('pertanyaan.pg.destroy', $p->id_pertanyaan) }}" method="POST" 
                          onsubmit="return confirm('Hapus pertanyaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Tombol Tanda Tangan -->
    @if($pembuatan_pertanyaan)
        <a href="{{ route('tanda.tangan.asesmen', [$skema->id_skema, $pembuatan_pertanyaan->id_pembuatan_pertanyaan]) }}" 
           class="btn btn-primary">
            <i class="fas fa-signature"></i> Tanda Tangan Asesmen
        </a>
    @endif

    <!-- Daftar Penyusun -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">PENYUSUN</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>STATUS</th>
                        <th>No.</th>
                        <th>NAMA</th>
                        <th>NOMOR MET</th>
                        <th>TANGGAL TANDA TANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($asesor as $a)
                        @if(!empty($a->tgl_ttd_asesor))
                            <tr>
                                <td class="text-center">PENYUSUN</td>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $a->nama_asesor }}</td>
                                <td>{{ $a->no_registrasi }}</td>
                                <td>{{ $a->tgl_ttd_asesor }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection