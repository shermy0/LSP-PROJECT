<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Asesi;
use App\Models\AsesmenMandiriMaster;
use App\Models\AsesmenMandiriJawaban;
use App\Models\AsesmenMandiriPersetujuan;

class AsesmenMandiriController extends Controller
{
    /**
     * List semua asesi yang sudah mengisi asesmen mandiri
     */
    public function index()
    {
        $asesi = DB::table('asesi')
            ->join('users', 'asesi.user_id', '=', 'users.id')
            ->select('asesi.asesi_id', 'asesi.nama_lengkap', 'users.email')
            ->get();

        return view('asesor.asesmen_mandiri.index', compact('asesi'));
    }

    /**
     * Detail asesmen mandiri untuk verifikasi
     */
    public function show($asesi_id)
    {
        $asesi = Asesi::with('user')->findOrFail($asesi_id);

        $asesmen = AsesmenMandiriMaster::where('asesi_id', $asesi_id)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$asesmen) {
            return redirect()->route('asesor.asesmen_mandiri.index')
                ->with('error', 'Asesi belum mengisi asesmen mandiri.');
        }

        // 🔹 Jawaban asesi
        $jawaban = AsesmenMandiriJawaban::where('id_asesmen_mandiri', $asesmen->id_asesmen_mandiri)
            ->with(['dokumen', 'kuk'])
            ->get()
            ->keyBy('id_kuk');

        // 🔹 Ambil skema permohonan terakhir
        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.skema_id', '=', 'skema_sertifikasi.id_skema')
            ->where('asesi_id', $asesi_id)
            ->latest('id_permohonan')
            ->select('skema_sertifikasi.nama_skema as skema', 'permohonan.skema_id')
            ->first();

        // 🔹 Ambil struktur skema (unit → elemen → kuk)
        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $permohonan->id_skema ?? 0)
            ->get();

        $elemen = DB::table('elemen_kompetensi')
            ->select('id_elemen', 'id_unit', 'nama_elemen')
            ->whereIn('id_unit', $units->pluck('id_unit'))
            ->get();

        $kuk = DB::table('kuk')
            ->whereIn('id_elemen', $elemen->pluck('id_elemen'))
            ->get();

        // 🔹 Ambil persetujuan (tanda tangan asesi jika ada)
        $persetujuan = AsesmenMandiriPersetujuan::where('id_asesmen_mandiri', $asesmen->id_asesmen_mandiri)->first();

        return view('asesor.asesmen_mandiri.show', compact(
            'asesi',
            'asesmen',
            'jawaban',
            'permohonan',
            'units',
            'elemen',
            'kuk',
            'persetujuan'
        ));
    }

    /**
     * Simpan hasil verifikasi asesor
     */
    public function verifikasiStore(Request $request, $asesi_id)
    {
        // 🔹 Sesuaikan validasi dengan enum tabel
        $request->validate([
            'rekomendasi' => 'required|in:Dapat Dilanjutkan,Tidak Dapat Dilanjutkan',
        ]);

        $asesmen = AsesmenMandiriMaster::where('asesi_id', $asesi_id)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$asesmen) {
            return back()->with('error', 'Asesi belum mengisi asesmen mandiri.');
        }

        // 🔹 Simpan tanda tangan asesor sebagai file
        $fileName = null;
        if ($request->filled('ttd_asesor')) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd_asesor);
            $image = str_replace(' ', '+', $image);
            $fileName = 'ttd/asesor_' . time() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($image));
        }

        // 🔹 Update rekomendasi di master
        $asesmen->update([
            'id_asesor'   => Auth::id(),
            'rekomendasi' => $request->rekomendasi,
        ]);

        // 🔹 Simpan/update persetujuan
        AsesmenMandiriPersetujuan::updateOrCreate(
            ['id_asesmen_mandiri' => $asesmen->id_asesmen_mandiri],
            [
                'tgl_ttd_asesor'    => now()->toDateString(),
                'ttd_asesor'        => $fileName,
                'status_persetujuan'=> $request->status_persetujuan ?? 'diterima',
                'catatan'           => $request->catatan,
            ]
        );

        return redirect()->route('asesor.asesmen_mandiri.index')
            ->with('success', '✅ Verifikasi berhasil disimpan.');
    }
}
