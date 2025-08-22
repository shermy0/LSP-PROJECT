@extends('master')

@section('konten')
<div class="container">
    <h3>FR.MAPA.01 - Merencanakan Aktivitas dan Proses Asesmen</h3>

    <div class="mb-3">
        <label for="skema">Skema:</label>
        <select id="skema" name="id_skema" class="form-control">
            <option value="">-- Pilih Skema --</option>
            @foreach($skema as $s)
                <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Jenis Skema:</label><br>
        <input type="radio" name="jenis_skema" value="KKNI"> KKNI
        <input type="radio" name="jenis_skema" value="Okupasi"> Okupasi
    </div>

    <div class="mb-3">
        <label for="kode_skema">Nomor Skema:</label>
        <input type="text" id="kode_skema" name="kode_skema" class="form-control" readonly>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('skema').addEventListener('change', function() {
        let skemaId = this.value;
        if(skemaId){
            fetch(`/form-perencanaan/get-skema/${skemaId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('kode_skema').value = data.kode_skema;
            });
        } else {
            document.getElementById('kode_skema').value = '';
        }
    });
</script>
@endpush
