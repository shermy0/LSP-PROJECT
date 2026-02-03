@extends('master')

@section('konten')
<div class="container mt-4">
    @foreach($kelompok->unitKompetensi as $uIndex => $unit)
        <div class="card mb-4 shadow-sm">
            <div class="card-header" style="background-color:#041562; color:white; font-weight:bold;">
                Evaluasi Unit: {{ $unit->judul_unit ?? $unit->kode_unit }}
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Skema: <span class="fw-bold">{{ $skema->nama_skema ?? $id_skema ?? '-' }}</span> |
                    Timer: <span class="fw-bold">{{ $timer ?? '-' }} menit</span> |
                    Kelompok: <span class="fw-bold">{{ $kelompok->nama_kelompok ?? '-' }}</span>
                </p>

                <form id="formPMO{{ $unit->id_unit }}" action="{{ route('pmo.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_skema" value="{{ $skema->id_skema ?? $id_skema }}">
                    <input type="hidden" name="id_kelompok" value="{{ $kelompok->id_kelompok ?? $id_kelompok }}">
                    <input type="hidden" name="id_unit" value="{{ $unit->id_unit }}">
                    <input type="hidden" name="timer" value="{{ $timer ?? 30 }}">

                    <div id="daftarPertanyaanPMO{{ $unit->id_unit }}">
                        @for($i = 1; $i <= ($jumlah ?? 5); $i++)
                        <div class="card mb-3 shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pertanyaan {{ $i }}</label>
                                    <textarea name="pertanyaan[{{ $unit->id_unit }}][]" class="form-control rounded-3" rows="2"
                                        placeholder="Masukkan pertanyaan ke-{{ $i }}" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Deskripsi / Petunjuk (Opsional)</label>
                                    <textarea name="deskripsi_pertanyaan[{{ $unit->id_unit }}][]" class="form-control rounded-3" rows="2"
                                        placeholder="Opsional: deskripsi atau petunjuk"></textarea>
                                </div>
                           </div>
                        </div>
                        @endfor
                    </div>
                </form>  
            </div>
        </div>
    @endforeach
</div>

<div class="text-center mt-4 d-flex gap-2 justify-content-center">
                        <button type="button" 
                                class="btn btn-save-pmo px-4 fw-bold text-white" 
                                data-unit="{{ $unit->id_unit }}"
                                data-unitjudul="{{ $unit->judul_unit ?? $unit->kode_unit }}"
                                style="background-color:#041562; border-radius:8px; padding:0.5rem 1.5rem;">
                            Simpan Pertanyaan PMO
                        </button>
                        <a href="{{ route('formasesmen.pmo', $skema->id_skema) }}" 
                        class="btn btn-secondary px-4 fw-bold" 
                        style="border-radius:8px; padding:0.5rem 1.5rem;">
                            Batal / Kembali
                        </a>
                    </div>
{{-- SweetAlert2 --}}
<script>
document.querySelectorAll('.btn-save-pmo').forEach(button => {
    button.addEventListener('click', function() {
        let unitId = this.dataset.unit;
        let unitJudul = this.dataset.unitjudul;
        Swal.fire({
            title: `<span style="color:#041562; font-weight:bold;">Unit: ${unitJudul}</span>`,
            html: '<p style="margin-top:0.5rem;">Apa yang ingin Anda lakukan? Anda dapat menambah pertanyaan lagi atau langsung menyimpan.</p>',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Lanjutkan / Simpan',
            denyButtonText: 'Tambah Pertanyaan',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-confirm btn fw-bold',
                denyButton: 'swal2-deny btn fw-bold',
                cancelButton: 'swal2-cancel btn fw-bold'
            },
            didRender: () => {
                const btnStyle = (btn, bg) => {
                    btn.style.backgroundColor = bg;
                    btn.style.color = '#fff';
                    btn.style.borderRadius = '8px';
                    btn.style.padding = '0.5rem 1.5rem';
                    btn.style.margin = '0.25rem';
                }
                btnStyle(document.querySelector('.swal2-confirm'), '#041562');
                btnStyle(document.querySelector('.swal2-deny'), '#041562');
                btnStyle(document.querySelector('.swal2-cancel'), '#6c757d');
            }
        }).then((result) => {
            if(result.isConfirmed){
                document.getElementById('formPMO'+unitId).submit();
            } else if(result.isDenied){
                let daftar = document.getElementById('daftarPertanyaanPMO'+unitId);
                let count = daftar.querySelectorAll('.card').length + 1;
                let newCard = document.createElement('div');
                newCard.classList.add('card','mb-3','shadow-sm','border-0','rounded-4');
                newCard.innerHTML = `
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pertanyaan ${count}</label>
                            <textarea name="pertanyaan[${unitId}][]" class="form-control rounded-3" rows="2"
                                placeholder="Masukkan pertanyaan ke-${count}" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi / Petunjuk (Opsional)</label>
                            <textarea name="deskripsi_pertanyaan[${unitId}][]" class="form-control rounded-3" rows="2"
                                placeholder="Opsional: deskripsi atau petunjuk"></textarea>
                        </div>
                    </div>
                `;
                daftar.appendChild(newCard);
            }
        });
    });
});
</script>
@endsection