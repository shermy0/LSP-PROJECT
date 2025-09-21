<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demonstrasi;
use App\Models\Skema;
use Illuminate\Support\Facades\Storage;

class DemonstrasiController extends Controller
{
    /**
     * Menampilkan daftar demonstrasi untuk sebuah skema
     * Route yang disarankan: GET /form-asesmen/pertanyaan-demonstrasi/{id_skema}
     */
    public function index($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $demonstrasi = Demonstrasi::with(['Asesor', 'kuk'])
            ->where('id_skema', $id_skema)
            ->get();

        return view('demonstrasi', compact('skema', 'demonstrasi'));
    }

    /**
     * Tampilkan form create (mengambil id_skema dari route param atau query string)
     * Route yang disarankan: GET /demonstrasi/create/{id_skema}
     */
    public function create(Request $request, $id_skema = null)
    {
        // Ambil id_skema dari route param dulu; kalau null, fallback ke query string
        if (!$id_skema) {
            $id_skema = $request->query('id_skema');
        }

        $skema = Skema::findOrFail($id_skema);

        // jika ingin form yang membuat beberapa pertanyaan (jumlah & timer),
        // kamu bisa menambahkan query parameter ?jumlah=5&timer=30 saat redirect dari blade demonstrasi
        $jumlah = $request->query('jumlah', 1);
        $timer  = $request->query('timer', 30);

        return view('input_demonstrasi', compact('skema', 'jumlah', 'timer'));
    }

    /**
     * Simpan demonstrasi baru ke DB
     * Route: POST /demonstrasi/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_skema'  => 'required|integer',
            'id_asesor' => 'required|integer',
            'id_tuk'    => 'nullable|integer',
            'id_kuk'    => 'nullable|integer',
            'instruksi' => 'required|string',
            'timer'     => 'required|integer|min:1',
            'file'      => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:10240'
        ]);

        $demonstrasi = new Demonstrasi();
        $demonstrasi->id_skema  = $request->id_skema;
        $demonstrasi->id_asesor = $request->id_asesor;
        $demonstrasi->id_tuk    = $request->id_tuk;
        $demonstrasi->id_kuk    = $request->id_kuk;
        $demonstrasi->instruksi = $request->instruksi;
        $demonstrasi->timer     = $request->timer;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads/demonstrasi', 'public');
            $demonstrasi->file_path = $filePath;
            $demonstrasi->file_type = $file->getClientOriginalExtension();
        }

        $demonstrasi->save();

        // IMPORTANT: gunakan route yang benar. Saya rekomendasikan redirect ke halaman CRUD per skema
        return redirect()->route('demonstrasi.crud', $demonstrasi->id_skema)
                         ->with('success', 'Tugas demonstrasi berhasil dibuat!');
    }

    /**
     * CRUD per skema (list demonstrasi untuk skema)
     * Route: GET /demonstrasi/{id_skema}/crud
     */
    public function crud($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);
        $demonstrasi = Demonstrasi::where('id_skema', $id_skema)->get();

        return view('demonstrasi_crud', compact('demonstrasi', 'skema'));
    }

    /**
     * Edit form
     */
    public function edit($id)
    {
        $demonstrasi = Demonstrasi::findOrFail($id);
        $skema = Skema::find($demonstrasi->id_skema);

        return view('input_demonstrasi_edit', compact('demonstrasi', 'skema'));
    }

    /**
     * Update
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
            // hapus file lama jika perlu
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
     * Hapus
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
}
