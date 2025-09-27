@extends('master')

@section('konten')
<div class="container my-4">
    <form action="{{ route('kerahasiaan.store') }}" method="POST">
        @csrf

        <!-- Header -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body text-center">
                <h6 class="text-muted">Form Asesmen > FR.AK.01</h6>
                <h4 class="fw-bold mt-2">PERSETUJUAN ASESMEN DAN KERAHASIAAN</h4>
                <p class="mt-2 text-secondary">
                    Persetujuan Asesmen ini untuk menjamin bahwa Asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen.
                </p>
            </div>
        </div>

        <!-- Skema -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white fw-bold text-center" style="background:#0d3b66">
                {{ $persetujuan->skema->nama_skema ?? 'JUNIOR OPERATOR DESAIN GRAFIS' }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Skema Sertifikasi</label>
                        <input type="text" class="form-control readonly-input"
                               value="{{ $persetujuan->skema->nama_skema ?? '' }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Okupasi</label>
                        <input type="text" class="form-control readonly-input"
                               value="{{ $persetujuan->skema->jenjang ?? '' }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor</label>
                        <input type="text" class="form-control readonly-input"
                               value="{{ $persetujuan->id_persetujuan ?? 'OK01' }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Uji Kompetensi</label>
                         <select name="tuk" class="form-control">
                            @foreach($tuk as $item)
                                <option value="{{ $item->id }}"
                                    {{ $persetujuan?->tuk?->id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_tuk }}
                                </option>
                            @endforeach
                        </select>    
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Asesi</label>
                        <select name="asesi" class="form-control">
                            @forelse($asesi ?? [] as $item)
                                @if(is_object($item))
                                    <option value="{{ $item->id_asesi }}"
                                        {{ (string) ($currentAsesiId ?? ($persetujuan->id_asesi ?? '')) === (string) $item->id_asesi ? 'selected' : '' }}>
                                        {{ $item->nama_lengkap }}
                                    </option>
                                @endif
                            @empty
                                <option value="">-- Tidak ada data Asesi --</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Asesor</label>
                        <input type="text" class="form-control readonly-input"
                               value="{{ Auth::user()->name }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bukti -->
       <table class="table table-bordered">
    <thead class="table-primary text-center">
        <tr>
            <th style="width: 50px;">No</th>
            <th>Bukti Yang Dikumpulkan</th>
            <th style="width: 50px;">✔</th>
        </tr>
    </thead>
    <tbody>
    @foreach($masterBukti as $index => $bukti)
<tr>
    <td class="text-center">{{ $index+1 }}</td>
    <td>{{ $bukti->nama_bukti }}</td>
    <td class="text-center">
        <input type="checkbox" name="bukti[]" value="{{ $bukti->id_jenis_bukti }}">
    </td>
</tr>
@endforeach

</tbody>

</table>


        <!-- Jadwal -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white fw-bold" style="background:#0d3b66">
                Jadwal Asesmen
            </div>
            <div class="card-body">
                <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="col-md-4">
    <label class="form-label">Waktu</label>
    <div class="input-group">
        <input type="time" id="timepicker" name="waktu" class="form-control" required>
        <button type="button" class="btn btn-outline-secondary" id="setNow">saat ini</button>
    </div>
</div>
    <div class="col-md-4">
        <label class="form-label">TUK</label>
        <select name="tuk" class="form-control">
            @foreach($tuk as $item)
                <option value="{{ $item->id }}"
                    {{ $persetujuan?->tuk?->id == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_tuk }}
                </option>
            @endforeach
        </select>
    </div>
</div>

            </div>
        </div>

        <!-- Pernyataan -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white fw-bold" style="background:#0d3b66">
                Pernyataan
            </div>
            <div class="card-body">
                <div class="mb-3 p-3 bg-light border rounded">
                    <strong>Asesi :</strong>
                    <p>Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor.</p>
                </div>
                <div class="mb-3 p-3 bg-light border rounded">
                    <strong>Asesor :</strong>
                    <p>Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai Asesor kecuali kepada pihak berwenang sesuai kewajiban saya sebagai Asesor LSP.</p>
                </div>
                <div class="mb-3 p-3 bg-light border rounded">
                    <strong>Asesi :</strong>
                    <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Simpan Form</button>
        </div>
    </form>
</div>
@endsection