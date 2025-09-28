<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;

class KonfirmasiController extends Controller
{
    // TAMPILKAN FORM KONFIRMASI
    public function konfirmasi($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

        // Ambil status konfirmasi (jika ada)
        $konfirmasi = DB::table('mapa01_konfirmasi')
            ->where('id_skema', $skema_id)
            ->first();

        // Ambil semua asesor yang terkait dengan skema
        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        // Ambil data orang relevan (per role) dari tabel penyusun_persetujuan
        $roles = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->whereIn('role', ['manajer_lsp', 'master_asesor', 'manajer_pelatihan', 'supervisor'])
            ->get()
            ->keyBy('role'); // hasilnya bisa dipanggil $roles['master_asesor']

        // Ambil daftar penyusun (role = penyusun)
        $penyusun = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->where('role', 'penyusun')
            ->get();

        return view('form_perencanaan.form_mapa_01.mapa01_konfirmasi', compact(
            'skema',
            'asesors',
            'konfirmasi',
            'roles',
            'penyusun'
        ));
    }

    // SIMPAN DATA ORANG RELEVAN + PENYUSUN
    public function store(Request $request, $skema_id)
    {
        /** SIMPAN ORANG RELEVAN (manajer, asesor, supervisor) */
        if ($request->has('asesor')) {
            foreach ($request->asesor as $role => $idAsesor) {
                if (!$idAsesor) continue;

                $ttdBase64 = $request->tanda_tangan[$role] ?? null;

                DB::table('penyusun_persetujuan')->updateOrInsert(
                    [
                        'id_skema'  => $skema_id,
                        'role'      => $role,
                    ],
                    [
                        'id_asesor'    => $idAsesor,
                        'tanggal'      => $request->tanggal[$role] ?? null,
                        'tanda_tangan' => $ttdBase64,
                    ]
                );
            }
        }

        /** SIMPAN PENYUSUN */
        if ($request->has('nama')) {
            foreach ($request->nama as $i => $nama) {
                if (!$nama) continue;

                $ttdBase64 = $request->tanda_tangan[$i] ?? null;

                DB::table('penyusun_persetujuan')->insert([
                    'id_skema'     => $skema_id,
                    'id_asesor'    => null,
                    'no_met'       => $request->nomet[$i] ?? null,
                    'tanggal'      => $request->tanggal[$i] ?? null,
                    'tanda_tangan' => $ttdBase64,
                    'role'         => 'penyusun',
                    'catatan'      => null
                ]);
            }
        }

        return redirect()->route('form.mapa01.konfirmasi', $skema_id)
            ->with('success', 'Data konfirmasi berhasil disimpan.');
    }

    // Hapus tanda tangan (set kolom tanda_tangan jadi null)
    public function deleteTtd($id)
    {
        DB::table('penyusun_persetujuan')
            ->where('id', $id)
            ->update(['tanda_tangan' => null]);

        return back()->with('success', 'Tanda tangan berhasil dihapus.');
    }

    // DOWNLOAD TANDA TANGAN (dari base64 jadi PNG)
    public function downloadTtd($id)
    {
        $data = DB::table('penyusun_persetujuan')->where('id', $id)->first();

        if (!$data || !$data->tanda_tangan) {
            return back()->with('error', 'Tanda tangan tidak ditemukan.');
        }

        // Decode base64 → binary
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data->tanda_tangan));

        // Nama file download
        $fileName = 'tanda_tangan_' . $id . '.png';

        // Return response sebagai file download
        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
