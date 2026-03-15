<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesi;
use App\Models\PenyesuaianWajar;

class PenyesuaianWajarController extends Controller
{
    /**
     * Menampilkan daftar penyesuaian wajar milik asesi.
     */
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        $penyesuaian = PenyesuaianWajar::with([
                'permohonan.skema', // relasi ke permohonan, lalu ke skema
                'persetujuan'
            ])
            ->where('id_asesi', $asesi->id_asesi)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asesi.penyesuaian_wajar.index', compact('penyesuaian'));
    }

    /**
     * Menampilkan detail penyesuaian wajar.
     */
    public function show($id)
    {
        $penyesuaian = PenyesuaianWajar::with([
            'permohonan.skema',
            'permohonan.persetujuan.tuk', // ambil data TUK dari persetujuan
            'asesor.user',
            'potensi',
            'items.keteranganItems', // relasi ke keterangan per item
            'persetujuan'
        ])->findOrFail($id);

        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        if ($penyesuaian->id_asesi != $asesi->id_asesi) {
            abort(403);
        }

        return view('asesi.penyesuaian_wajar.show', compact('penyesuaian'));
    }

    /**
     * Menyimpan tanda tangan asesi.
     */
    public function storeSignature(Request $request, $id)
    {
        $penyesuaian = PenyesuaianWajar::findOrFail($id);
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();

        if ($penyesuaian->id_asesi != $asesi->id_asesi) {
            abort(403);
        }

        // Asesi hanya boleh menandatangani jika status = 'menunggu_asesi'
        if ($penyesuaian->status !== 'menunggu_asesi') {
            return back()->with('error', 'Tanda tangan hanya dapat dilakukan saat status "Menunggu Tanda Tangan Anda".');
        }

        $request->validate([
            'ttd_asesi'    => 'required|string',
            'tgl_ttd_asesi' => 'required|date',
            'setuju'       => 'required|accepted', // checkbox persetujuan harus dicentang
        ]);

        $ttdPath = $this->saveSignature($request->ttd_asesi, 'asesi');
        DB::table('penyesuaian_wajar_persetujuan')->updateOrInsert(
            ['id_penyesuaian' => $id],
            [
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi'     => $ttdPath,
            ]
        );

        // Ubah status menjadi 'menunggu_asesor' (selanjutnya asesor yang menandatangani)
        $penyesuaian->update(['status' => 'menunggu_asesor']);

        return redirect()->route('asesi.penyesuaian_wajar.show', $id)
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }

    /**
     * Simpan file signature dari base64.
     */
    private function saveSignature($base64, $prefix)
    {
        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = $prefix . '_' . time() . '.png';
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));
        return 'ttd/' . $fileName;
    }
}