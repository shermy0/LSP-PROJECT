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
            ->join('permohonan', 'asesi.id_asesi', '=', 'permohonan.id_asesi')
            ->join('asesmen_mandiri_master', 'permohonan.id_permohonan', '=', 'asesmen_mandiri_master.id_permohonan')
            ->select(
                'asesi.id_asesi',
                'asesi.nama_lengkap',
                'asesi.nik',
                'asesi.email',
                'asesi.telepon_hp as telepon',
                'permohonan.updated_at'
            )
            ->distinct()
            ->paginate(10);

        return view('asesor.asesmen_mandiri.index', compact('asesi'));
    }

    /**
     * Detail asesmen mandiri untuk verifikasi
     */
    public function show($id_asesi)
    {
        $asesi = Asesi::with('user')->findOrFail($id_asesi);

        $asesmen = AsesmenMandiriMaster::where('id_asesi', $id_asesi)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$asesmen) {
            return redirect()->route('asesor.asesmen_mandiri.index')
                ->with('error', 'Asesi belum mengisi asesmen mandiri.');
        }

        $jawaban = AsesmenMandiriJawaban::where('id_asesmen_mandiri', $asesmen->id_asesmen_mandiri)
            ->with(['dokumen', 'kuk'])
            ->get()
            ->keyBy('id_kuk');

        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.id_asesi', $id_asesi)
            ->latest('permohonan.id_permohonan')
            ->select('skema_sertifikasi.nama_skema as skema', 'permohonan.id_skema')
            ->first();

        if (!$permohonan) {
            return redirect()->route('asesor.asesmen_mandiri.index')
                ->with('error', 'Data permohonan tidak ditemukan.');
        }

        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $permohonan->id_skema)
            ->get();

        $elemen = DB::table('elemen_kompetensi')
            ->select('id_elemen', 'id_unit', 'nama_elemen')
            ->whereIn('id_unit', $units->pluck('id_unit'))
            ->get();

        $kuk = DB::table('kuk')
            ->whereIn('id_elemen', $elemen->pluck('id_elemen'))
            ->get();

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
    public function verifikasiStore(Request $request, $id_asesi)
    {
        $request->validate([
            'rekomendasi' => 'required|in:Dapat Dilanjutkan,Tidak Dapat Dilanjutkan',
        ]);

        $asesmen = AsesmenMandiriMaster::where('id_asesi', $id_asesi)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$asesmen) {
            return back()->with('error', 'Asesi belum mengisi asesmen mandiri.');
        }

        $fileName = null;
        if ($request->filled('ttd_asesor')) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd_asesor);
            $image = str_replace(' ', '+', $image);
            $fileName = 'ttd/asesor_' . time() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($image));
        }

        $asesmen->update([
            'id_asesor'   => Auth::id(),
            'rekomendasi' => $request->rekomendasi,
        ]);

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