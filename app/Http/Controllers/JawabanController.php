<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            return redirect()->route('login')->withErrors([
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

        return view('essai_asesi', compact('pertanyaan', 'id_skema', 'jawaban', 'timer', 'timescap', 'asesi'));
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
            return redirect()->route('login')->withErrors([
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

        // Simpan tanda tangan jika ada
        if ($request->has('ttd_asesi') && !empty($request->ttd_asesi)) {
            // Ubah base64 menjadi file gambar
            $ttdData = $request->ttd_asesi;
            $ttdData = preg_replace('#^data:image/\w+;base64,#i', '', $ttdData);
            $ttdData = str_replace(' ', '+', $ttdData);
            $imageData = base64_decode($ttdData);

            // Nama file: nama_as esi + tanggal
            $namaAsesi = Str::slug($asesi->nama_lengkap, '_');
            $tanggal = $request->tgl_ttd_asesi ?: date('Y-m-d');
            $fileName = $namaAsesi . '_' . $tanggal . '.png';
            $filePath = storage_path('app/public/ttd/' . $fileName);

            // Pastikan folder ada
            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            // Simpan file ke storage
            file_put_contents($filePath, $imageData);

            // Cari id_jawaban terakhir
            $id_jawaban = JawabanAsesmen::where('id_asesi', $idAsesi)
                ->where('id_skema', $request->id_skema)
                ->orderBy('id_jawaban', 'desc')
                ->first()
                ->id_jawaban ?? null;

            // Simpan ke tabel jawaban_asesmen_persetujuan
            DB::table('jawaban_asesmen_persetujuan')->updateOrInsert(
                ['id_jawaban' => $id_jawaban],
                [
                    'tgl_ttd_asesi' => $tanggal,
                    'ttd_asesi' => 'storage/ttd/' . $fileName, // simpan path, bukan base64
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Kalau request dari AJAX, balikin JSON biar bisa redirect otomatis
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('asesi.dashboard')->with('success', 'Jawaban berhasil disimpan!');
    }
}
