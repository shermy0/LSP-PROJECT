<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\AsesmenMandiriMaster;
use App\Models\AsesmenMandiriJawaban;
use App\Models\AsesmenMandiriPersetujuan;

class AsesmenMandiriController extends Controller
{
    /**
     * List semua asesi yang sudah mengisi asesmen mandiri dan ditugaskan ke asesor ini.
     */
    public function index()
    {
        $user = Auth::user();
        $asesor = Asesor::where('user_id', $user->id)->first();

        if (!$asesor) {
            return redirect()->back()->with('error', 'Data asesor tidak ditemukan.');
        }

        // Ambil asesi yang ditugaskan ke asesor ini dan memiliki asesmen mandiri
        $asesi = Asesi::where('asesor_id', $asesor->id_asesor)
            ->whereHas('asesmenMandiriMaster') // pastikan relasi ada di model Asesi
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('asesor.asesmen_mandiri.index', compact('asesi'));
    }

    /**
     * Detail asesmen mandiri untuk verifikasi
     */
    public function show($id_asesi)
    {
        $user = Auth::user();
        $asesor = Asesor::where('user_id', $user->id)->first();

        if (!$asesor) {
            abort(403, 'Anda bukan asesor.');
        }

        $asesi = Asesi::with('user')->findOrFail($id_asesi);

        // Pastikan asesi ini ditugaskan ke asesor yang login
        if ($asesi->asesor_id != $asesor->id_asesor) {
            abort(403, 'Anda tidak berhak mengakses asesi ini.');
        }

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
        $user = Auth::user();
        $asesor = Asesor::where('user_id', $user->id)->first();

        if (!$asesor) {
            abort(403, 'Anda bukan asesor.');
        }

        $asesi = Asesi::findOrFail($id_asesi);
        if ($asesi->asesor_id != $asesor->id_asesor) {
            abort(403, 'Anda tidak berhak memverifikasi asesi ini.');
        }

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