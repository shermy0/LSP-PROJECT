<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\JawabanAsesmen;
use App\Models\Asesi;
use App\Models\PembuatanPertanyaan;

class JawabanController extends Controller
{
    /**
     * Tampilkan daftar pertanyaan esai dan jawaban user
     */
    public function index($id_skema)
    {
        // Cek user login
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Cek data Asesi
        $asesi = Asesi::where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('dashboard')->withErrors([
                'error' => 'Data Asesi tidak ditemukan. Hubungi admin.'
            ]);
        }

        // Ambil pertanyaan esai berdasarkan skema
        $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'esai')
            ->where('id_skema', $id_skema)
            ->get();

        // Ambil jawaban user yang sudah ada
        $jawaban = JawabanAsesmen::where('id_asesi', $asesi->id_asesi)
            ->where('id_skema', $id_skema)
            ->pluck('jawaban_text', 'id_pertanyaan')
            ->toArray();

        // Ambil data timer dari tabel pembuatan_pertanyaan
        $pembuatan = PembuatanPertanyaan::where('id_skema', $id_skema)->first();
        $timer = $pembuatan ? $pembuatan->timer : 0; // menit
        $timescap = $pembuatan ? $pembuatan->timescap : null;

        return view('essai_asesi', compact('pertanyaan', 'id_skema', 'jawaban', 'timer', 'timescap'));
    }

    /**
     * Simpan atau update jawaban user
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_skema' => 'required',
            'jawaban' => 'required|array'
        ]);

        // Cek user login
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Cek data Asesi
        $asesi = Asesi::where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('dashboard')->withErrors([
                'error' => 'Data Asesi tidak ditemukan. Hubungi admin.'
            ]);
        }

        $idAsesi = $asesi->id_asesi;

        // Simpan/Update jawaban untuk setiap pertanyaan
        foreach ($request->jawaban as $id_pertanyaan => $text) {
            JawabanAsesmen::updateOrCreate(
                [
                    'id_asesi' => $idAsesi,
                    'id_skema' => $request->id_skema,
                    'id_pertanyaan' => $id_pertanyaan
                ],
                [
                    'jawaban_text' => $text,
                    'jawaban_opsi' => null
                ]
            );
        }

        // Kalau request dari AJAX, balikin JSON biar bisa redirect otomatis
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Jawaban berhasil disimpan!');
    }
}
