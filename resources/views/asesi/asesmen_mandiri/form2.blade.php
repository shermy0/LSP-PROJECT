@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
    <div class="container">

        <form id="asesmenForm" action="{{ route('asesi.asesmen_mandiri.store') }}" method="POST">
            @csrf

            @foreach($units as $unit)

                <div class="unit-header">
                    <p class="mb-1 fw-semibold">Unit Kompetensi {{ $loop->iteration }}</p>
                    <p class="mb-0">Kode Unit : {{ $unit->kode_unit }}</p>
                    <p class="mb-0">Judul Unit : {{ $unit->judul_unit }}</p>
                </div>

                @php
                    $elemenUnit = $elemen->where('id_unit', $unit->id_unit);
                @endphp

                @foreach($elemenUnit as $e)

                    <div class="question-box">

                        <div class="question-title">
                            <span class="number">{{ $loop->iteration }}</span>
                            <span class="text">{{ $e->judul_elemen }}</span>
                        </div>

                        <table class="table-custom">

                            <thead>
                                <tr>
                                    <th style="width:5%">NO</th>
                                    <th style="width:60%">Elemen</th>
                                    <th style="width:8%">K</th>
                                    <th style="width:8%">BK</th>
                                    <th style="width:19%">Bukti</th>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                    $kukElemen = $kuk->where('id_elemen', $e->id_elemen);
                                @endphp

                                @foreach($kukElemen as $k)

                                    @php
                                        $jawab = $jawaban[$k->id_kuk] ?? null;
                                    @endphp

                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td class="td-deskripsi">
                                            {{ $k->deskripsi_kuk }}
                                            <div class="invalid-msg"></div>
                                        </td>

                                        <td class="text-center">

                                            <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="K" class="radio-kuk" required {{ $jawab && $jawab->status == 'K' ? 'checked' : '' }}>

                                        </td>

                                        <td class="text-center">

                                            <input type="radio" name="kuk[{{ $k->id_kuk }}]" value="BK" class="radio-kuk" {{ $jawab && $jawab->status == 'BK' ? 'checked' : '' }}>

                                        </td>

                                        <td>

                                            <select name="bukti[{{ $k->id_kuk }}]" class="form-select bukti-select" required>

                                                <option value="">Pilih Dokumen</option>

                                                @foreach($dokumen as $d)

                                                    <option value="{{ $d->id_dokumen }}" {{ $jawab && $jawab->id_dokumen == $d->id_dokumen ? 'selected' : '' }}>

                                                        {{ $d->nama_jenis }} ({{ basename($d->file_path) }})

                                                    </option>

                                                @endforeach

                                            </select>

                                            <div class="invalid-msg"></div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endforeach
            @endforeach


            <div class="button-group mt-4">

                <a href="{{ route('asesi.asesmen_mandiri.form1') }}" class="btn-back">
                    Kembali
                </a>

                <button type="submit" class="btn-next">
                    Simpan dan Lanjut
                </button>

            </div>

        </form>
    </div>
@endsection



<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f9f9fb;
    }

    .container {
        max-width: 850px;
        margin: 20px auto;
    }

    .unit-header {
        background: #E9F1FF;
        border-left: 6px solid #007BFF;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .question-box {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
    }

    .question-title {
        display: flex;
        align-items: center;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 15px;
    }

    .question-title .number {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #041562;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        margin-right: 10px;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        background: #fff;
    }

    .table-custom th,
    .table-custom td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .table-custom th {
        background: #f5f5f5;
        text-align: center;
        font-weight: 600;
    }

    .table-custom input[type="radio"] {
        width: 18px;
        height: 18px;
    }

    .bukti-select {
        background: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 13px;
        cursor: pointer;
        text-align: center;
        color: #555;
    }

    .bukti-select:hover {
        background: #e2e2e2;
    }

    .is-invalid {
        border: 2px solid #d9534f !important;
        background: #fff8f8 !important;
    }

    .invalid-msg {
        color: #d9534f;
        font-size: 12px;
        margin-top: 4px;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-back {
        background: #d9534f;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-next {
        background: #041562;
        color: #fff;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
    }

    .btn-back:hover {
        background: #c9302c;
    }

    .btn-next:hover {
        background: #06208a;
    }
</style>



<script>

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('asesmenForm');

        const radios = form.querySelectorAll('.radio-kuk');

        radios.forEach(radio => {

            radio.addEventListener('invalid', function () {

                const td = this.closest('tr').querySelector('.td-deskripsi');

                td.classList.add('is-invalid');

                const msg = td.querySelector('.invalid-msg');

                msg.innerText = 'Pilih K atau BK';

            });

            radio.addEventListener('change', function () {

                const td = this.closest('tr').querySelector('.td-deskripsi');

                td.classList.remove('is-invalid');

                const msg = td.querySelector('.invalid-msg');

                msg.innerText = '';

            });

        });


        const selects = form.querySelectorAll('.bukti-select');

        selects.forEach(select => {

            select.addEventListener('invalid', function () {

                this.classList.add('is-invalid');

                const msg = this.parentElement.querySelector('.invalid-msg');

                msg.innerText = 'Wajib pilih bukti';

            });

            select.addEventListener('change', function () {

                this.classList.remove('is-invalid');

                const msg = this.parentElement.querySelector('.invalid-msg');

                msg.innerText = '';

            });

        });

    });

</script>