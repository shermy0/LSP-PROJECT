<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;

class KonfirmasiController extends Controller
{
    public function konfirmasi($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

        // Ambil data konfirmasi
        $konfirmasi = DB::table('mapa01_konfirmasi')
            ->where('id_skema', $skema_id)
            ->first();

        // Ambil semua asesor
        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        // Ambil data orang relevan per role
        $rolesData = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->whereIn('role', ['manajer_lsp', 'master_asesor', 'manajer_pelatihan', 'supervisor'])
            ->get();

        $roleLabels = [
            'manajer_lsp'       => 'Manajer Sertifikasi LSP',
            'master_asesor'     => 'Master Asesor / Lead Asesor',
            'manajer_pelatihan' => 'Manajer Pelatihan',
            'supervisor'        => 'Supervisor di Tempat Kerja',
        ];

        $activeRoles = [];
        foreach ($roleLabels as $role => $label) {
            $field = 'konfirmasi_' . $role;
            if ($konfirmasi && $konfirmasi->$field) {
                $dataRole = $rolesData->firstWhere('role', $role); // ambil data sesuai role
                $activeRoles[$role] = [
                    'label' => $label,
                    'data'  => $dataRole,
                ];
            }
        }

        // Ambil semua penyusun
        $penyusun = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->where('role', 'penyusun')
            ->get();

        return view('form_perencanaan.form_mapa_01.mapa01_konfirmasi', compact(
            'skema',
            'asesors',
            'konfirmasi',
            'activeRoles',
            'penyusun'
        ));
    }

    public function store(Request $request, $skema_id)
    {
        // Simpan Orang Relevan
        if ($request->has('asesor')) {
            foreach ($request->asesor as $role => $idAsesor) {
                if (!$idAsesor) continue;

                $ttdBase64 = $request->tanda_tangan[$role] ?? null;

                DB::table('penyusun_persetujuan')->updateOrInsert(
                    ['id_skema' => $skema_id, 'role' => $role],
                    [
                        'id_asesor'    => $idAsesor,
                        'tanggal'      => $request->tanggal[$role] ?? null,
                        'tanda_tangan' => $ttdBase64,
                    ]
                );
            }
        }
// Simpan Penyusun
if ($request->has('nama_asesor')) {
    foreach ($request->nama_asesor as $i => $idAsesor) {
        if (!$idAsesor) continue;

        $ttdBase64 = $request->tanda_tangan[$i] ?? null;

        // Ambil no_met dari tabel asesor
        $asesorData = DB::table('asesor')->where('id_asesor', $idAsesor)->first();
        $noMet = $asesorData->no_registrasi ?? ($request->nomet[$i] ?? null);

        DB::table('penyusun_persetujuan')->updateOrInsert(
            ['id_skema' => $skema_id, 'id_asesor' => $idAsesor, 'role' => 'penyusun'],
            [
                'no_met'       => $noMet,
                'tanggal'      => $request->tanggal[$i] ?? null,
                'tanda_tangan' => $ttdBase64,
            ]
        );
    }
}


        return redirect()->route('form.mapa01.konfirmasi', $skema_id)
            ->with('success', 'Data konfirmasi berhasil disimpan.');
    }

    // Hapus TTD
    public function deleteTtd($id)
    {
        $updated = DB::table('penyusun_persetujuan')
            ->where('id', $id)
            ->update(['tanda_tangan' => null]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Tanda tangan berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menghapus tanda tangan'], 400);
    }

    // Download TTD
    public function downloadTtd($id)
    {
        $data = DB::table('penyusun_persetujuan')->where('id', $id)->first();

        if (!$data || !$data->tanda_tangan) {
            return back()->with('error', 'Tanda tangan tidak ditemukan.');
        }

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data->tanda_tangan));
        $fileName = 'tanda_tangan_' . $id . '.png';

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
