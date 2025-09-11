<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Skema;
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
        $jumlah = $request->get('jumlah', 5); // default 5 pertanyaan
        $id_unit = 1; // nanti bisa diganti sesuai jurusan
        $id_skema = 1;

        return view('pertanyaan.input_lisan', compact('id_unit', 'id_skema', 'jumlah'));
    }

    public function storeLisan(Request $request)
    {
        $request->validate([
            'id_unit'        => 'required|integer',
            'id_skema'       => 'required|integer',
            'id_asesor'      => 'required|integer',
            'isi_pertanyaan' => 'required|array|min:1',
        ]);

        foreach ($request->isi_pertanyaan as $isi) {
            Pertanyaan::create([
                'id_unit'          => $request->id_unit,
                'id_skema'         => $request->id_skema,
                'id_asesor'        => $request->id_asesor,
                'jenis_pertanyaan' => 'lisan',
                'isi_pertanyaan'   => $isi,
            ]);
        }

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan lisan berhasil ditambahkan!');
    }

    // ================================
    // FORM ESAI
    // ================================
  public function createEsai(Request $request)
{
    $jumlah = $request->query('jumlah', 5); // default 5
    $id_skema = $request->query('id_skema');

    // ambil skema tunggal
    $skema = Skema::findOrFail($id_skema);

    return view('input_esai', compact('skema', 'jumlah'));
}



public function storeEsai(Request $request)
{
    $request->validate([
        'id_skema' => 'required|integer',
        'id_asesor' => 'required|integer',
        'isi_pertanyaan' => 'required|array|min:1',
        'kunci_jawaban' => 'nullable|array',
        'file.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
    ]);

    $files = $request->file('file', []);

    foreach ($request->isi_pertanyaan as $i => $isi) {
        $filePath = null;
        $fileType = null;

        if (isset($files[$i]) && $files[$i]->isValid()) {
            $file = $files[$i];
            $filePath = $file->store('uploads/pertanyaan', 'public');
            $fileType = $file->getClientOriginalExtension();
        }

        Pertanyaan::create([
            'id_unit' => null,
            'id_skema' => $request->id_skema,
            'id_asesor' => $request->id_asesor,
            'jenis_pertanyaan' => 'esai',
            'isi_pertanyaan' => $isi,
            'kunci_jawaban' => $request->kunci_jawaban[$i] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);
    }

    return redirect()->route('esai.crud')->with('success', 'Pertanyaan esai berhasil ditambahkan!');
}




    // ================================
    // FORM PILIHAN GANDA (PG)
    // ================================
    public function createPG(Request $request)
    {
        $jumlah = $request->get('jumlah', 5); 
        $id_unit = 1;
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

            // kalau mau simpan opsi ke tabel opsi_jawaban, bisa ditambahin di sini
        }

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan PG berhasil ditambahkan!');
    }

    public function crudEsai()
{
    $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'esai')->get();
    return view('esai_crud', compact('pertanyaan'));
}

// ================================
// EDIT ESAI
// ================================
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
        'kunci_jawaban' => 'nullable|string',
        'file' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
    ]);

    // Handle file baru jika ada
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $filePath = $file->store('uploads/pertanyaan', 'public');
        $fileType = $file->getClientOriginalExtension();
        $pertanyaan->file_path = $filePath;
        $pertanyaan->file_type = $fileType;
    }

    $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
    $pertanyaan->kunci_jawaban = $request->kunci_jawaban;
    $pertanyaan->save();

    return redirect()->route('esai.crud')->with('success', 'Pertanyaan esai berhasil diupdate!');
}

// ================================
// HAPUS ESAI
// ================================
public function destroyEsai($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);

    // Hapus file jika ada
    if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
        \Storage::disk('public')->delete($pertanyaan->file_path);
    }

    $pertanyaan->delete();
    return redirect()->route('esai.crud')->with('success', 'Pertanyaan esai berhasil dihapus!');
}

}