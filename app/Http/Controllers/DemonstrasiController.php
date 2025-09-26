<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demonstrasi;
use App\Models\MasterTugasDemonstrasi;
use App\Models\SkemaSertifikasi;
use App\Models\KelompokPekerjaan;
use Illuminate\Support\Facades\Storage;

class DemonstrasiController extends Controller
{
    /**
     * Menampilkan daftar demonstrasi untuk sebuah skema
     * Route: GET /form-asesmen/pertanyaan-demonstrasi/{id_skema}
     */
    public function index($id_skema)
    {
        $skema = SkemaSertifikasi::findOrFail($id_skema);

        $demonstrasi = Demonstrasi::with('asesor')
            ->where('id_skema', $id_skema)
            ->get();

        return view('demonstrasi', compact('skema', 'demonstrasi'));
    }

    /**
     * Tampilkan form create
     * Route: GET /demonstrasi/create/{id_skema}
     */
    public function create(Request $request, $id_skema = null)
    {
        if (!$id_skema) {
            $id_skema = $request->query('id_skema');
        }

        $skema = SkemaSertifikasi::findOrFail($id_skema);

        $jumlah = $request->query('jumlah', 1);
        $timer  = $request->query('timer', 30);

        return view('input_demonstrasi', compact('skema', 'jumlah', 'timer'));
    }

    /**
     * Simpan demonstrasi baru
     * Route: POST /demonstrasi/store
     */
    public function store(Request $request)
{
    $request->validate([
        'id_skema'  => 'required|integer',
        'id_asesor' => 'required|integer',
        'timer'     => 'required|integer|min:1',
    ]);

    // ✅ Ambil skema dulu
    $skema = SkemaSertifikasi::findOrFail($request->id_skema);

    $demonstrasi = new Demonstrasi();
    $demonstrasi->id_skema   = $request->id_skema;
    $demonstrasi->id_asesor  = $request->id_asesor;
    $demonstrasi->id_asesmen = $request->id_asesmen ?? 1; 
    $demonstrasi->instruksi  = $request->instruksi 
                               ?? "Tugas demonstrasi untuk skema " . $skema->nama_skema;
    $demonstrasi->timer      = $request->timer;
    $demonstrasi->save();

    return redirect()->route('demonstrasi.crud', $demonstrasi->id_skema)
                     ->with('success', 'Tugas demonstrasi berhasil dibuat!');
}

    /**
     * CRUD per skema
     * Route: GET /demonstrasi/{id_skema}/crud
     */
    public function crud($id_skema)
    {
        $skema = SkemaSertifikasi::findOrFail($id_skema);
        $demonstrasi = Demonstrasi::where('id_skema', $id_skema)->get();

        return view('demonstrasi_crud', compact('demonstrasi', 'skema'));
    }

    /**
     * Edit form
     * Route: GET /demonstrasi/{id}/edit
     */
    public function edit($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $skema = SkemaSertifikasi::find($demonstrasi->id_skema);

        return view('input_demonstrasi_edit', compact('demonstrasi', 'skema'));
    }

    /**
     * Update demonstrasi
     * Route: PUT /demonstrasi/{id}/update
     */
    public function update(Request $request, $id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);

        $request->validate([
            'instruksi' => 'required|string',
            'timer'     => 'required|integer|min:1',
            'file'      => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:10240'
        ]);

        $demonstrasi->instruksi = $request->instruksi;
        $demonstrasi->timer     = $request->timer;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($demonstrasi->file_path && Storage::disk('public')->exists($demonstrasi->file_path)) {
                Storage::disk('public')->delete($demonstrasi->file_path);
            }
            $file = $request->file('file');
            $filePath = $file->store('uploads/demonstrasi', 'public');
            $demonstrasi->file_path = $filePath;
            $demonstrasi->file_type = $file->getClientOriginalExtension();
        }

        $demonstrasi->save();

        return redirect()->route('demonstrasi.crud', $demonstrasi->id_skema)
                         ->with('success', 'Tugas demonstrasi berhasil diupdate!');
    }

    /**
     * Hapus demonstrasi
     * Route: DELETE /demonstrasi/{id}/delete
     */
    public function destroy($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $id_skema = $demonstrasi->id_skema;

        if ($demonstrasi->file_path && Storage::disk('public')->exists($demonstrasi->file_path)) {
            Storage::disk('public')->delete($demonstrasi->file_path);
        }

        $demonstrasi->delete();

        return redirect()->route('demonstrasi.crud', $id_skema)
                         ->with('success', 'Tugas demonstrasi berhasil dihapus!');
    }

    /**
     * Halaman kelompok pekerjaan demonstrasi
     * Route: GET /form-asesmen/{id_skema}/kelompok-demonstrasi
     */
    

public function kelompokPekerjaanDemo(Request $request, $id_skema)
{
    // ambil skema
    $skema = SkemaSertifikasi::findOrFail($id_skema);

    // ambil semua kelompok pekerjaan berdasarkan id_skema
    $kelompok = KelompokPekerjaan::where('id_skema', $id_skema)
                ->with('unitKompetensi')
                ->get();

    // optional: ambil parameter jumlah dan timer dari request
    $jumlah = $request->get('jumlah', null);
    $timer  = $request->get('timer', null);

    return view('kelompok_pekerjaan_demo', compact('skema', 'kelompok', 'jumlah', 'timer'));
}

}
