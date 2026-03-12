@extends('master')

@section('konten')
<div class="container mt-4">
    <!-- Header dengan warna #041562 -->
    <div class="card border-0 mb-4" style="background-color: #041562;">
        <div class="card-body py-4">
            <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle p-3 me-3 shadow" style="color: #041562;">
                    <i class="fas fa-question-circle fa-2x"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1 text-white">FR.IA.07 – Daftar Pertanyaan Pilihan Ganda</h3>
                    <p class="mb-0 text-white-50">Kelola semua pertanyaan pilihan ganda dalam satu tempat</p>
                </div>
            </div>
        </div>
    </div>

    @forelse($pertanyaan as $index => $p)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">
                        <span class="badge me-2" style="background-color: #041562;">{{ $index+1 }}</span>
                        Pertanyaan Pilihan Ganda
                    </h6>
                    <span class="badge bg-info">ID: {{ $p->id_pertanyaan }}</span>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Pertanyaan -->
                <div class="mb-4">
                    <label class="text-muted text-uppercase small fw-bold mb-2">
                        <i class="fas fa-question-circle me-1" style="color: #041562;"></i>Pertanyaan:
                    </label>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0">{{ $p->isi_pertanyaan }}</p>
                    </div>
                </div>

                <!-- File Lampiran -->
                @if($p->file_path)
                <div class="mb-4">
                    <label class="text-muted text-uppercase small fw-bold mb-2">
                        <i class="fas fa-paperclip me-1" style="color: #041562;"></i>Lampiran:
                    </label>
                    <div class="bg-light rounded p-3">
                        <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank" 
                           class="btn btn-sm" style="background-color: #041562; color: white; border: none;">
                            <i class="fas fa-eye"></i> Lihat File
                        </a>

                        @if(in_array($p->file_type, ['jpg','jpeg','png']))
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$p->file_path) }}" 
                                     alt="Gambar Pertanyaan" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="max-width:200px; max-height:150px;">
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Opsi Jawaban -->
                <div class="mb-4">
                    <label class="text-muted text-uppercase small fw-bold mb-2">
                        <i class="fas fa-list me-1" style="color: #041562;"></i>Opsi Jawaban:
                    </label>
                    <div class="row g-3">
                        @foreach($p->opsiJawaban as $opsi)
                            <div class="col-md-6">
                                <div class="card border h-100" style="{{ $opsi->benar ? 'border-color: #041562; background-color: rgba(4, 21, 98, 0.05);' : 'border-color: #dee2e6;' }}">
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge me-2" style="{{ $opsi->benar ? 'background-color: #041562;' : 'background-color: #6c757d;' }}">
                                                {{ $opsi->kode_opsi }}
                                            </span>
                                            
                                            @if(str_contains($opsi->isi_opsi, 'uploads/opsi_jawaban'))
                                                <img src="{{ asset('storage/'.$opsi->isi_opsi) }}" 
                                                     class="img-thumbnail border-0" 
                                                     style="max-height: 50px;">
                                            @else
                                                <span class="flex-grow-1">{{ $opsi->isi_opsi }}</span>
                                            @endif
                                            
                                            @if($opsi->benar)
                                                <span class="badge ms-2" style="background-color: #041562;">
                                                    <i class="fas fa-check"></i> Kunci
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kunci Jawaban -->
                <div class="mb-4 p-3 rounded" style="background-color: rgba(4, 21, 98, 0.05);">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3" style="background-color: #041562; color: white;">
                            <i class="fas fa-key fa-sm"></i>
                        </div>
                        <div>
                            <span class="text-muted small">KUNCI JAWABAN</span>
                            <h5 class="mb-0 fw-bold" style="color: #041562;">{{ $p->kunci_jawaban }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 justify-content-end border-top pt-3">
                    <a href="{{ route('pertanyaan.pg.edit', $p->id_pertanyaan) }}" 
                       class="btn btn-warning btn-sm px-4">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    
                    <form action="{{ route('pertanyaan.pg.destroy', $p->id_pertanyaan) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-4">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info border-0 shadow-sm">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada pertanyaan yang ditambahkan.
        </div>
    @endforelse

    <!-- Daftar Penyusun -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header py-3 text-white" style="background-color: #041562;">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-users me-2"></i>
                DAFTAR PENYUSUN
            </h5>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #041562; color: white;">
                        <tr>
                            <th class="text-center" width="120">STATUS</th>
                            <th class="text-center" width="60">No.</th>
                            <th>NAMA</th>
                            <th>NOMOR MET</th>
                            <th>TANGGAL TANDA TANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse($asesor as $a)
                            @if(!empty($a->tgl_ttd_asesor))
                                <tr>
                                    <td class="text-center">
                                        <span class="badge" style="background-color: #041562;">PENYUSUN</span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $i++ }}</td>
                                    <td>{{ $a->nama_asesor }}</td>
                                    <td>{{ $a->no_registrasi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tgl_ttd_asesor)->format('d/m/Y') }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-info-circle text-muted me-2"></i>
                                    Belum ada penyusun yang terdaftar
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tombol Navigasi -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <a href="{{ route('formasesmen.pertanyaanPG', $skema->id_skema) }}" 
           class="btn px-4 text-white" style="background-color: #6c757d; border: none;">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        
        <span class="text-muted small">
            <i class="fas fa-info-circle me-1" style="color: #041562;"></i>
            Total: {{ $pertanyaan->count() }} Pertanyaan
        </span>
    </div>
</div>

<!-- Custom Styles -->
<style>
.text-white-50 {
    color: rgba(255, 255, 255, 0.7);
}

.card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 10px;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(4, 21, 98, 0.1) !important;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(4, 21, 98, 0.2);
}

.btn[style*="background-color: #041562"]:hover {
    opacity: 0.9;
}

.table thead th {
    border-bottom: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
    border-radius: 6px;
}

.alert {
    border-radius: 10px;
}

/* Hover effect untuk baris tabel */
.table-hover tbody tr:hover {
    background-color: rgba(4, 21, 98, 0.02);
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn {
        width: 100%;
        margin: 2px 0;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
    }
}
</style>
@endsection