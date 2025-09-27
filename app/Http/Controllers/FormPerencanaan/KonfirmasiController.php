<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;

class KonfirmasiController extends Controller
{
// BUAT NYARI ASESOR SESUAI SKEMA DI FILE KONFIRMASI
public function search(Request $request)
{
    $term = $request->get('q');
    $skemaId = $request->get('skema_id');

    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skemaId)
        ->where('asesor.nama_asesor', 'LIKE', "%{$term}%")
        ->select('asesor.id_asesor', 'asesor.nama_asesor')
        ->limit(10)
        ->get();

    return response()->json($asesors);
}

  // Method untuk menampilkan halaman konfirmasi
public function konfirmasi($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    // Ambil data konfirmasi sebelumnya
    $konfirmasi = DB::table('mapa01_konfirmasi')
        ->where('id_skema', $skema_id)
        ->first();

    // Ambil semua asesor terkait skema
    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skema_id)
        ->select('asesor.id_asesor', 'asesor.nama_asesor')
        ->get();

    return view('form_perencanaan.form_mapa_01.mapa01_konfirmasi', compact('skema', 'asesors', 'konfirmasi'));
}

    public function store(Request $request, $skema_id)
    {
        if ($request->has('nama')) {
            foreach ($request->nama as $index => $nama) {
                $ttdBase64 = $request->tanda_tangan[$index] ?? null;
                $ttdPath = null;

                if ($ttdBase64) {
                    // decode base64
                    $imageData = base64_decode(str_replace('data:image/png;base64,', '', $ttdBase64));
                    $fileName = 'ttd_' . uniqid() . '.png';
                    $ttdPath = 'ttd/' . $fileName;

                    // simpan ke storage
                    Storage::disk('public')->put($ttdPath, $imageData);
                }

                DB::table('penyusun_persetujuan')->insert([
                    'id_skema'     => $skema_id,
                    'id_asesor'    => $request->asesor[$index] ?? null,
                    'no_met'       => $request->nomet[$index] ?? null,
                    'tanggal'      => $request->tanggal[$index] ?? null,
                    'tanda_tangan' => $ttdBase64,
                    'catatan'      => null,
                ]);
            }
        }

        return redirect()->route('form.mapa01.konfirmasi', $skema_id)
            ->with('success', 'Data konfirmasi berhasil disimpan.');
    }

    public function downloadTtd($id)
    {
        $penyusun = DB::table('penyusun_persetujuan')->find($id);
        if (!$penyusun || !$penyusun->tanda_tangan_path) {
            abort(404);
        }

        return Storage::disk('public')->download($penyusun->tanda_tangan_path);
    }

    public function deleteTtd($id)
    {
        $penyusun = DB::table('penyusun_persetujuan')->find($id);
        if ($penyusun && $penyusun->tanda_tangan_path) {
            Storage::disk('public')->delete($penyusun->tanda_tangan_path);
        }

        DB::table('penyusun_persetujuan')
            ->where('id', $id)
            ->update(['tanda_tangan' => null, 'tanda_tangan_path' => null]);

        return back()->with('success', 'Tanda tangan berhasil dihapus.');
    }

}