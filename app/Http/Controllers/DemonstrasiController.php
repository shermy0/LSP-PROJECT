<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demonstrasi;
use App\Models\MasterTugasDemonstrasi;
use App\Models\SkemaSertifikasi;
use App\Models\KelompokPekerjaan;
use App\Models\Asesmen;
use Illuminate\Support\Facades\Storage;

class DemonstrasiController extends Controller
{
    /**
     * Menampilkan daftar demonstrasi untuk sebuah asesmen
     * Route: GET /form-asesmen/pertanyaan-demonstrasi/{id_asesmen}
     */
    public function index($id_asesmen)
    {
        $asesmen = Asesmen::with('skema')->findOrFail($id_asesmen);

        $demonstrasi = Demonstrasi::with(['asesor', 'tugas'])
            ->where('id_asesmen', $id_asesmen)
            ->get();

        return view('demonstrasi', [
            'asesmen'      => $asesmen,
            'skema'        => $asesmen->skema,
            'demonstrasi'  => $demonstrasi
        ]);
    }

    /**
     * Tampilkan form create
     * Route: GET /demonstrasi/create/{id_asesmen}
     */
    public function create($id_asesmen)
    {
        $asesmen = Asesmen::with('skema')->findOrFail($id_asesmen);
        $timer   = 30;

        return view('input_demonstrasi', [
            'asesmen' => $asesmen,
            'skema'   => $asesmen->skema,
            'timer'   => $timer
        ]);
    }

    /**
     * Simpan demonstrasi baru
     * Route: POST /demonstrasi/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_asesmen' => 'required|integer|exists:asesmen,id_asesmen',
            'id_asesor'  => 'required|integer',
            'timer'      => 'required|integer|min:1',
        ]);

        $asesmen = Asesmen::with('skema')->findOrFail($request->id_asesmen);

        $demonstrasi = new Demonstrasi();
        $demonstrasi->id_asesmen = $asesmen->id_asesmen;
        $demonstrasi->id_asesor  = $request->id_asesor;
        $demonstrasi->instruksi  = $request->instruksi 
                                   ?? "Tugas demonstrasi untuk skema " . $asesmen->skema->nama_skema;
        $demonstrasi->timer      = $request->timer;
        $demonstrasi->save();

        return redirect()->route('pertanyaan.demonstrasi.kelompok', $asesmen->id_asesmen)
                         ->with('success', 'Tugas demonstrasi berhasil dibuat!');
    }

    /**
     * CRUD per asesmen
     * Route: GET /demonstrasi/{id_asesmen}/crud
     */
    public function crud($id_asesmen)
    {
        $asesmen = Asesmen::with('skema')->findOrFail($id_asesmen);

        $demonstrasi = Demonstrasi::with('tugas')
            ->where('id_asesmen', $id_asesmen)
            ->get();

        return view('demonstrasi_crud', [
            'asesmen'     => $asesmen,
            'skema'       => $asesmen->skema,
            'demonstrasi' => $demonstrasi
        ]);
    }

    /**
     * Edit form
     * Route: GET /demonstrasi/{id}/edit
     */
    public function edit($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $asesmen     = $demonstrasi->asesmen()->with('skema')->first();

        return view('input_demonstrasi_edit', [
            'demonstrasi' => $demonstrasi,
            'asesmen'     => $asesmen,
            'skema'       => $asesmen->skema
        ]);
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

        return back()->with('success', 'Tugas demonstrasi berhasil diupdate!');
    }

    /**
     * Hapus demonstrasi
     * Route: DELETE /demonstrasi/{id}/delete
     */
    public function destroy($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);

        if ($demonstrasi->file_path && Storage::disk('public')->exists($demonstrasi->file_path)) {
            Storage::disk('public')->delete($demonstrasi->file_path);
        }

        MasterTugasDemonstrasi::where('id_demonstrasi', $id)->delete();
        $demonstrasi->delete();

        return back()->with('success', 'Tugas demonstrasi berhasil dihapus!');
    }

    /**
     * Halaman kelompok pekerjaan demonstrasi
     * Route: GET /form-asesmen/{id_asesmen}/kelompok-demonstrasi
     */
    public function kelompokPekerjaanDemo(Request $request, $id_asesmen)
{
    $asesmen = Asesmen::with('skema')->findOrFail($id_asesmen);
    $skema = $asesmen->skema;

    $kelompok = KelompokPekerjaan::where('id_skema', $skema->id_skema)
                ->with('unitKompetensi')
                ->get();

    $timer  = $request->get('timer', null);

    return view('kelompok_pekerjaan_demo', compact('asesmen','skema','kelompok','timer'));
}

}
