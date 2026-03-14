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
    public function index()
    {
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        $penyesuaian = PenyesuaianWajar::with(['asesmen.permohonan.skema'])
            ->where('id_asesi', $asesi->id_asesi)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('asesi.penyesuaian_wajar.index', compact('penyesuaian'));
    }

    public function show($id)
    {
        $penyesuaian = PenyesuaianWajar::with([
            'asesmen.permohonan.skema',
            'asesor',
            'potensi',
            'items',
            'persetujuan'
        ])->findOrFail($id);

        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();
        if ($penyesuaian->id_asesi != $asesi->id_asesi) {
            abort(403);
        }

        return view('asesi.penyesuaian_wajar.show', compact('penyesuaian'));
    }

    public function storeSignature(Request $request, $id)
    {
        $penyesuaian = PenyesuaianWajar::findOrFail($id);
        $asesi = Asesi::where('user_id', Auth::id())->firstOrFail();

        if ($penyesuaian->id_asesi != $asesi->id_asesi) {
            abort(403);
        }

        if ($penyesuaian->status !== 'draf') {
            return back()->with('error', 'Tidak dapat menandatangani pada status ini.');
        }

        $request->validate([
            'ttd_asesi' => 'required|string',
            'tgl_ttd_asesi' => 'required|date',
            'setuju' => 'required|accepted', // checkbox setuju harus dicentang
        ]);

        $ttdPath = $this->saveSignature($request->ttd_asesi, 'asesi');
        DB::table('penyesuaian_wajar_persetujuan')->updateOrInsert(
            ['id_penyesuaian' => $id],
            [
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi' => $ttdPath,
            ]
        );
        $penyesuaian->update(['status' => 'menunggu_asesor']);

        return redirect()->route('asesi.penyesuaian_wajar.show', $id)
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }

    private function saveSignature($base64, $prefix)
    {
        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = $prefix . '_' . time() . '.png';
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));
        return 'ttd/' . $fileName;
    }
}