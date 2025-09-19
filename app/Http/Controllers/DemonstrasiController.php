<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demonstrasi;
use App\Models\Skema;

class DemonstrasiController extends Controller
{
    // ================================
    // INDEX: List Semua Tugas Demonstrasi
    // ================================
    public function index()
    {
        $demonstrasi = Demonstrasi::with('Asesor', 'kuk')->get();
        return view('demonstrasi', compact('demonstrasi'));

    }

    // ================================
    // CREATE: Form Buat Tugas Demonstrasi
    // ================================
    public function create(Request $request)
    {
        $id_skema = $request->query('id_skema');
        $skema    = Skema::findOrFail($id_skema);

        return view('input_demonstrasi', compact('skema'));
    }

    // ================================
    // STORE: Simpan Tugas Demonstrasi ke DB
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'id_skema'   => 'required|integer',
            'id_asesor'  => 'required|integer',
            'id_tuk'     => 'nullable|integer',
            'id_kuk'     => 'nullable|integer',
            'instruksi'  => 'required|string',
            'timer'      => 'required|integer|min:1',
            'file'       => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:10240'
        ]);

        $demonstrasi = new Demonstrasi();
        $demonstrasi->id_skema  = $request->id_skema;
        $demonstrasi->id_asesor = $request->id_asesor;
        $demonstrasi->id_tuk    = $request->id_tuk;
        $demonstrasi->id_kuk    = $request->id_kuk;
        $demonstrasi->instruksi = $request->instruksi;
        $demonstrasi->timer     = $request->timer;

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads/demonstrasi', 'public');
            $demonstrasi->file_path = $filePath;
            $demonstrasi->file_type = $file->getClientOriginalExtension();
        }

        $demonstrasi->save();

        return redirect()->route('demonstrasi.index')
                         ->with('success', 'Tugas demonstrasi berhasil dibuat!');
    }

    // ================================
    // CRUD PER SKEMA
    // ================================
    public function crud($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);
        $demonstrasi = Demonstrasi::where('id_skema', $id_skema)->get();

        return view('demonstrasi_crud', compact('demonstrasi', 'skema'));
    }

    // ================================
    // EDIT
    // ================================
    public function edit($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $skema = Skema::find($demonstrasi->id_skema);

        return view('input_demonstrasi_edit', compact('demonstrasi', 'skema'));
    }

    // ================================
    // UPDATE
    // ================================
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

        // Update file jika ada upload baru
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $filePath = $file->store('uploads/demonstrasi', 'public');
            $demonstrasi->file_path = $filePath;
            $demonstrasi->file_type = $file->getClientOriginalExtension();
        }

        $demonstrasi->save();

        return redirect()->route('demonstrasi.crud', $demonstrasi->id_skema)
                         ->with('success', 'Tugas demonstrasi berhasil diupdate!');
    }

    // ================================
    // DESTROY
    // ================================
    public function destroy($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $id_skema    = $demonstrasi->id_skema;

        // Hapus file kalau ada
        if ($demonstrasi->file_path && \Storage::disk('public')->exists($demonstrasi->file_path)) {
            \Storage::disk('public')->delete($demonstrasi->file_path);
        }

        $demonstrasi->delete();

        return redirect()->route('demonstrasi.crud', $id_skema)
                         ->with('success', 'Tugas demonstrasi berhasil dihapus!');
    }
}
