@extends('layouts.master')

@section('title', 'Asesmen Mandiri')

@section('content')
<div class="container">
    <form action="{{ route('asesi.asesmen_mandiri.store') }}" method="POST">
        @csrf

        @foreach($units as $unit)
            <!-- Header Unit -->
            <div class="unit-header">
                <h3>{{ $unit->kode_unit }} - {{ $unit->judul_unit }}</h3>
            </div>

            @php
                $elemenUnit = $elemen->where('id_unit', $unit->id_unit);
            @endphp

            @foreach($elemenUnit as $e)
                <div class="question-box">
                    <div class="question-title">
                        {{ $e->id_elemen }}. {{ $e->judul_elemen }}
                    </div>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:60%; text-align:center;">Kriteria Unjuk Kerja</th>
                                <th style="width:10%">K</th>
                                <th style="width:10%">BK</th>
                                <th style="width:15%">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $kukElemen = $kuk->where('id_elemen', $e->id_elemen);
                            @endphp

                            @foreach($kukElemen as $index => $k)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->deskripsi_kuk }}</td>
                                    <td>
                                        <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="K">
                                    </td>
                                    <td>
                                        <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="BK">
                                    </td>
                                    <td>
                                        <select name="bukti[{{ $k->id_kuk }}]" class="form-select">
                                            <option value="">Pilih Dokumen</option>
                                            @foreach($dokumen as $d)
                                                <option value="{{ $d->id_dokumen }}">
                                                    {{ $d->nama_jenis }} ({{ basename($d->file_path) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endforeach

        <!-- Tombol Aksi -->
        <div class="button-group mt-4">
            <a href="{{ route('asesi.asesmen_mandiri.form1') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-next">Simpan dan Lanjut</button>
        </div>
    </form>
</div>
@endsection
