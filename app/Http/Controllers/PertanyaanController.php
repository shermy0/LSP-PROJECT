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
    public function index()
    {
        $pertanyaan = Pertanyaan::all();
        return view('pertanyaan.index', compact('pertanyaan'));
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
            'id_skema'           => 'required|integer',
            'id_asesor'          => 'required|integer',
            'isi_pertanyaan.*'   => 'required|string',
            'kunci_jawaban.*'    => 'nullable|string',
        ]);

        $id_skema  = $request->id_skema;
        $id_asesor = $request->id_asesor;

        foreach ($request->isi_pertanyaan as $key => $isi) {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema         = $id_skema;
        $pertanyaan->id_asesor        = $id_asesor; // ambil dari form request
        $pertanyaan->jenis_pertanyaan = 'lisan';
        $pertanyaan->isi_pertanyaan   = $isi;
        $pertanyaan->kunci_jawaban    = $request->kunci_jawaban[$key] ?? null;
        $pertanyaan->save();
        }

        return redirect()->route('pertanyaan.index')
                         ->with('success', 'Pertanyaan lisan berhasil ditambahkan!');
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
        'id_kelompok'      => 'required|integer', // 🔹
        'isi_pertanyaan.*' => 'required|string',
        'kunci_jawaban.*'  => 'nullable|string',
        'file.*'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        'timer'            => 'required|integer',
    ]);

    $id_skema    = $request->id_skema;
    $id_asesor   = $request->id_asesor;
    $id_kelompok = $request->id_kelompok; // 🔹
    $timer       = $request->timer;

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
        $pertanyaan->id_kelompok = $id_kelompok; // 🔹 masuk sini
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

   return redirect()->route('esai.crud', [
    'id_skema'   => $id_skema,
    'id_kelompok'=> $id_kelompok
])->with('success', 'Semua pertanyaan esai berhasil disimpan dengan timer!');

}


    public function crudEsai($id_skema, $id_kelompok)
{
    $skema = Skema::findOrFail($id_skema);

    $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'esai')
                            ->where('id_skema', $id_skema)
                            ->where('id_kelompok', $id_kelompok) // ✅ filter kelompok juga
                            ->get();

    return view('esai_crud', compact('pertanyaan', 'skema', 'id_kelompok'));
}

   public function editEsai($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);
    $skema = Skema::find($pertanyaan->id_skema);

    return view('input_esai_edit', [
        'pertanyaan' => $pertanyaan,
        'skema'      => $skema,
        'id_skema'   => $pertanyaan->id_skema,
        'id_kelompok'=> $pertanyaan->id_kelompok
    ]);

    
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

    return redirect()->route('esai.crud', [
        'id_skema'    => $pertanyaan->id_skema,
        'id_kelompok' => $pertanyaan->id_kelompok
    ])->with('success', 'Pertanyaan esai berhasil diupdate!');
}

    public function destroyEsai($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $id_skema   = $pertanyaan->id_skema;

        if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
            \Storage::disk('public')->delete($pertanyaan->file_path);
        }

        $pertanyaan->delete();

       return redirect()->route('esai.crud', [
    'id_skema'   => $id_skema,
    'id_kelompok'=> $pertanyaan->id_kelompok
])->with('success', 'Pertanyaan esai berhasil dihapus!');
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
public function kelompokPekerjaan(Request $request, $id_skema, $jenis = 'lisan')
{
    $timer = $request->query('timer');

    $kelompok = \App\Models\KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
        $q->where('unit_kompetensi.id_skema', $id_skema);
    }])->where('id_skema', $id_skema)->get();

    // Tentukan view berdasarkan jenis dari defaults() route
    if ($jenis === 'essai') {
        return view('kelompok_pekerjaan_essai', compact('kelompok', 'timer', 'id_skema'));
    }

    return view('kelompok_pekerjaan_lisan', compact('kelompok', 'timer', 'id_skema'));
}




}
