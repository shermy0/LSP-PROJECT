<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Skema;
use App\Models\PembuatanPertanyaan;
use Carbon\Carbon;

class PertanyaanController extends Controller
{
    // ================================
    // INDEX (CRUD List Semua Pertanyaan)
    // ================================
       public function index(Request $request)
{
    $id_skema  = $request->query('id_skema'); 
    $jenis     = $request->query('jenis'); // filter opsional: lisan/esai/pg
    $perKelompok = $request->query('kelompok', false);

    $skema = $id_skema ? \App\Models\Skema::find($id_skema) : null;

    // =============================
    // 1) Kalau per kelompok + lisan
    // =============================
   if ($perKelompok && $id_skema && $jenis === 'lisan') {
    $kelompok = \App\Models\KelompokPekerjaan::with(['pertanyaan' => function ($q) use ($id_skema) {
        $q->where('jenis_pertanyaan', 'lisan');
    }])
    ->where('id_skema', $id_skema)
    ->get();

    return view('lisan_crud', compact('skema', 'kelompok'));
    }
    // =============================
    // 2) Default: CRUD per jenis
    // =============================
    $pertanyaan = Pertanyaan::query()
        ->when($id_skema, fn($q) => $q->where('id_skema', $id_skema))
        ->when($jenis, fn($q) => $q->where('jenis_pertanyaan', $jenis))
        ->get();

    // Kalau jenis lisan → pakai lisan_crud
    if ($jenis === 'lisan') {
        return view('lisan_crud', compact('pertanyaan', 'skema'));
    }

    // Kalau jenis esai → pakai esai_crud
    if ($jenis === 'esai') {
        return view('esai_crud', compact('pertanyaan', 'skema'));
    }

    // Kalau jenis lain / belum dipilih → fallback
    return view('lisan_crud', compact('pertanyaan', 'skema'));
}

    // ================================
    // FORM LISAN
    // ================================
    public function createLisan(Request $request)
    {
        $jumlah   = $request->query('jumlah', 5); 
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);
        return view('input_lisan', compact('skema', 'jumlah'));
    }

        public function storeLisan(Request $request)
    {
       $request->validate([
    'id_skema'   => 'required|exists:skema_sertifikasi,id_skema',
    'pertanyaan' => 'required|string',
    ]);
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema = $request->id_skema;
        $pertanyaan->jenis = 'lisan';
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->save();

        // ✅ redirect ke CRUD lisan per skema
        return redirect()->route('lisan.crud', ['id_skema' => $request->id_skema])
                        ->with('success', 'Pertanyaan lisan berhasil ditambahkan!');
    }


         public function editLisan($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $skema = Skema::find($pertanyaan->id_skema);

        return view('input_lisan', compact('pertanyaan', 'skema'));
    }

    public function updateLisan(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kunci_jawaban'  => 'nullable|string',
            'file'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        ]);

        // upload file baru jika ada
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $filePath = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_path = $filePath;
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        }

        $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
        $pertanyaan->kunci_jawaban  = $request->kunci_jawaban;
        $pertanyaan->save();

        return redirect()->route('lisan.crud', ['id_skema' => $pertanyaan->id_skema])
                         ->with('success', 'Pertanyaan lisan berhasil diupdate!');
    }

    public function destroyLisan($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $id_skema   = $pertanyaan->id_skema;

        if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
            \Storage::disk('public')->delete($pertanyaan->file_path);
        }

        $pertanyaan->delete();

        return redirect()->route('lisan.crud', ['id_skema' => $id_skema])
                         ->with('success', 'Pertanyaan lisan berhasil dihapus!');
    }
        public function crudLisan($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'lisan')
                                ->where('id_skema', $id_skema)
                                ->get();

        return view('lisan_crud', compact('pertanyaan', 'skema'));
    }

    // ================================
    // FORM ESAI
    // ================================
    public function createEsai(Request $request)
    {
        $jumlah   = $request->query('jumlah', 5); 
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);

        return view('input_esai', compact('skema', 'jumlah'));
    }

    public function storeEsai(Request $request)
    {
        $request->validate([
            'id_skema'         => 'required|integer',
            'id_asesor'        => 'required|integer',
            'isi_pertanyaan.*' => 'required|string',
            'kunci_jawaban.*'  => 'nullable|string',
            'file.*'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
            'timer'            => 'required|integer',
        ]);

        $id_skema  = $request->id_skema;
        $id_asesor = $request->id_asesor;
        $timer     = $request->timer;

        // Simpan ke tabel pembuatan_pertanyaan
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $id_skema,
            'timer'    => $timer,
            'timescap' => now(),
        ]);

        // Simpan pertanyaan esai
        foreach ($request->isi_pertanyaan as $key => $isi) {
            $pertanyaan = new Pertanyaan();
            $pertanyaan->id_skema = $id_skema;
            $pertanyaan->id_asesor = $id_asesor;
            $pertanyaan->id_pembuatan_pertanyaan = $pembuatan->id_pembuatan_pertanyaan;
            $pertanyaan->jenis_pertanyaan = 'esai';
            $pertanyaan->isi_pertanyaan = $isi;
            $pertanyaan->kunci_jawaban = $request->kunci_jawaban[$key] ?? null;

            if ($request->hasFile("file.$key")) {
                $file = $request->file("file.$key");
                $filePath = $file->store('uploads/pertanyaan', 'public');
                $pertanyaan->file_path = $filePath;
                $pertanyaan->file_type = $file->getClientOriginalExtension();
            }

            $pertanyaan->save();
        }

        return redirect()->route('esai.crud', ['id_skema' => $id_skema])
                         ->with('success', 'Semua pertanyaan esai berhasil disimpan dengan timer!');
    }

    public function crudEsai($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'esai')
                                ->where('id_skema', $id_skema)
                                ->get();

        return view('esai_crud', compact('pertanyaan', 'skema'));
    }

    public function editEsai($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $skema = Skema::find($pertanyaan->id_skema);

        return view('input_esai_edit', compact('pertanyaan', 'skema'));
    }

    public function updateEsai(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kunci_jawaban'  => 'nullable|string',
            'file'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $filePath = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_path = $filePath;
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        }

        $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
        $pertanyaan->kunci_jawaban  = $request->kunci_jawaban;
        $pertanyaan->save();

        return redirect()->route('esai.crud', ['id_skema' => $pertanyaan->id_skema])
                         ->with('success', 'Pertanyaan esai berhasil diupdate!');
    }

    public function destroyEsai($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $id_skema   = $pertanyaan->id_skema;

        if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
            \Storage::disk('public')->delete($pertanyaan->file_path);
        }

        $pertanyaan->delete();

        return redirect()->route('esai.crud', ['id_skema' => $id_skema])
                         ->with('success', 'Pertanyaan esai berhasil dihapus!');
    }

    // ================================
    // FORM PILIHAN GANDA (PG)
    // ================================
    public function createPG(Request $request)
    {
        $jumlah   = $request->get('jumlah', 5); 
        $id_unit  = 1;
        $id_skema = 1;

        return view('pertanyaan.input_pg', compact('id_unit', 'id_skema', 'jumlah'));
    }

    public function storePG(Request $request)
    {
        $request->validate([
            'id_unit'        => 'required|integer',
            'id_skema'       => 'required|integer',
            'id_asesor'      => 'required|integer',
            'isi_pertanyaan' => 'required|array|min:1',
            'opsi'           => 'required|array',
            'kunci_jawaban'  => 'required|array',
        ]);

        foreach ($request->isi_pertanyaan as $index => $isi) {
            Pertanyaan::create([
                'id_unit'          => $request->id_unit,
                'id_skema'         => $request->id_skema,
                'id_asesor'        => $request->id_asesor,
                'jenis_pertanyaan' => 'pilihan_ganda',
                'isi_pertanyaan'   => $isi,
                'kunci_jawaban'    => $request->kunci_jawaban[$index] ?? null,
            ]);

            // Kalau mau simpan opsi ke tabel opsi_jawaban, bisa ditambahkan di sini
        }

        return redirect()->route('pertanyaan.index')
                         ->with('success', 'Pertanyaan PG berhasil ditambahkan!');
    }
public function kelompokPekerjaan(Request $request, $id_skema)
{
    $timer = $request->query('timer');

    $kelompok = \App\Models\KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
        $q->where('unit_kompetensi.id_skema', $id_skema);
    }])->where('id_skema', $id_skema)->get();

    return view('kelompok_pekerjaan_lisan', compact('kelompok', 'timer', 'id_skema'));
}


}
