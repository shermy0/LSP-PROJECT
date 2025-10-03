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
            ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi as no_met')
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

public function storeLaporanAsesor(Request $request, $skema_id)
{
    $request->validate([
        'asesor_id'    => 'required|exists:asesor,id_asesor',
        'catatan'      => 'nullable|string',
        'tanggal'      => 'nullable|date',
        'tanda_tangan' => 'nullable|string', // base64
    ]);

    $asesorData = DB::table('asesor')->where('id_asesor', $request->asesor_id)->first();
    $noMet = $asesorData->no_registrasi ?? null;

    // Ambil data lama (kalau ada)
    $existing = DB::table('penyusun_persetujuan')
        ->where('id_skema', $skema_id)
        ->where('id_asesor', $request->asesor_id)
        ->where('role', 'asesor')
        ->first();

    $dataUpdate = [
        'id_skema'  => $skema_id,
        'id_asesor' => $request->asesor_id,
        'no_met'    => $noMet,
        'catatan'   => $request->catatan,
        'tanggal'   => $request->tanggal ?? now(),
        'role'      => 'asesor',
    ];

    // Hanya update tanda tangan kalau ada input baru
    if (!empty($request->tanda_tangan)) {
        $dataUpdate['tanda_tangan'] = $request->tanda_tangan;
    } elseif ($existing) {
        // Kalau ga ada input baru, biarkan tanda tangan lama
        $dataUpdate['tanda_tangan'] = $existing->tanda_tangan;
    }

    DB::table('penyusun_persetujuan')->updateOrInsert(
        ['id_skema' => $skema_id, 'id_asesor' => $request->asesor_id, 'role' => 'asesor'],
        $dataUpdate
    );

return redirect()->route('form_perencanaan.laporan_asesmen.laporan_asesor', $skema_id)
    ->with('success', 'Data catatan dan tanda tangan asesor berhasil disimpan.')
    ->with('asesor_terpilih', $request->asesor_id)
    ->with('no_registrasi_terpilih', $noMet);
}


public function store(Request $request, $skema_id)
{
    // ✅ Bagian Orang Relevan (hanya ada di MAPA.01)
    if ($request->has('asesor')) {
        foreach ($request->asesor as $role => $idAsesor) {
            if (!$idAsesor) continue;

            $dataUpdate = [
                'id_asesor' => $idAsesor,
                'tanggal'   => $request->tanggal[$role] ?? null,
            ];

            if (!empty($request->tanda_tangan[$role])) {
                $dataUpdate['tanda_tangan'] = $request->tanda_tangan[$role];
            }

            DB::table('penyusun_persetujuan')->updateOrInsert(
                ['id_skema' => $skema_id, 'role' => $role],
                $dataUpdate
            );
        }
    }

    // ✅ Bagian Penyusun (ada di MAPA.01 dan MAPA.02)
    if ($request->has('nama_asesor')) {
        foreach ($request->nama_asesor as $i => $idAsesor) {
            if (!$idAsesor) continue;

            $asesorData = DB::table('asesor')->where('id_asesor', $idAsesor)->first();
            $noMet = $asesorData->no_registrasi ?? ($request->nomet[$i] ?? null);

            $dataUpdate = [
                'id_asesor' => $idAsesor,
                'no_met'    => $noMet,
                'tanggal'   => $request->tanggal[$i] ?? null,
                'role'      => 'penyusun',
            ];

            if (!empty($request->tanda_tangan[$i])) {
                $dataUpdate['tanda_tangan'] = $request->tanda_tangan[$i];
            }

            if (!empty($request->penyusun_id[$i])) {
                DB::table('penyusun_persetujuan')
                    ->where('id', $request->penyusun_id[$i])
                    ->update($dataUpdate);
            } else {
                $dataUpdate['id_skema'] = $skema_id;
                DB::table('penyusun_persetujuan')->insert($dataUpdate);
            }
        }
    }

    return redirect()->back()->with('success', 'Data penyusun berhasil disimpan');
}


public function deletePenyusun($id)
{
    try {
        $deleted = DB::table('penyusun_persetujuan')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Penyusun berhasil dihapus.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data penyusun tidak ditemukan.'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server.',
            'error'   => $e->getMessage()
        ], 500);
    }
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
