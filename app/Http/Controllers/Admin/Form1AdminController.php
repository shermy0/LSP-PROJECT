<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Form1AdminController extends Controller
{
    /**
     * Menampilkan daftar permohonan dengan status Diajukan
     */
    public function index()
    {
        $asesi = DB::table('asesi')
            ->join('permohonan', 'permohonan.id_asesi', '=', 'asesi.id_asesi')
            ->where('permohonan.status', 'Diajukan')
            ->select(
                'asesi.id_asesi',
                'asesi.nama_lengkap',
                'asesi.nik',
                'asesi.email',
                'asesi.telepon_hp as telepon',
                'permohonan.updated_at'
            )
            ->orderBy('permohonan.updated_at', 'desc')
            ->paginate(10);

        return view('admin.permohonan.index', compact('asesi'));
    }

    /**
     * Menampilkan detail permohonan berdasarkan id_asesi
     */
    public function show($id_asesi)
    {
        $asesi = DB::table('asesi')->where('id_asesi', $id_asesi)->first();
        if (!$asesi) {
            abort(404, 'Data Asesi tidak ditemukan');
        }

        $permohonan = DB::table('permohonan')
            ->leftJoin('tujuan_asesmen', 'permohonan.id_tujuan', '=', 'tujuan_asesmen.id_tujuan')
            ->where('permohonan.id_asesi', $id_asesi)
            ->select(
                'permohonan.*',
                'tujuan_asesmen.nama_tujuan as tujuan_asesmen'
            )
            ->orderBy('permohonan.tgl_permohonan', 'desc')
            ->first();

        if (!$permohonan) {
            return view('admin.permohonan.no-permohonan', compact('asesi'));
        }

        $skema = null;
        $units = collect();

        if (!empty($permohonan->id_skema)) {
            $skema = DB::table('skema_sertifikasi')
                ->where('id_skema', $permohonan->id_skema)
                ->first();

            $units = DB::table('unit_kompetensi')
                ->where('id_skema', $permohonan->id_skema)
                ->select('kode_unit', 'judul_unit', 'standar_kompetensi')
                ->get();
        }

        $tuk = null;
        if (!empty($permohonan->id_tuk)) {
            $tuk = DB::table('tuk')->where('id_tuk', $permohonan->id_tuk)->first();
        } else {
            $tuk = DB::table('tuk')->first(); // fallback
        }

        // Dokumen persyaratan beserta nilai memenuhi_syarat (jika sudah ada)
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.id_jenis_dokumen', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.id_permohonan', $permohonan->id_permohonan)
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.path_file',
                'dokumen_persyaratan.memenuhi_syarat',
                'jenis_dokumen.nama_dokumen as jenis'
            )
            ->get();

        $persetujuan = DB::table('permohonan_persetujuan')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        return view('admin.permohonan.show', compact(
            'asesi',
            'permohonan',
            'skema',
            'units',
            'dokumen',
            'persetujuan',
            'tuk'
        ));
    }

    /**
     * Memperbarui keputusan permohonan, status dokumen, dan tanda tangan admin
     * Otomatis menolak jika ada dokumen yang tidak memenuhi syarat
     */
    public function update(Request $request, $id_permohonan)
    {
        $request->validate([
            'status_permohonan' => 'required|in:Diterima,Ditolak',
            'catatan'           => 'nullable|string',
            'syarat'            => 'nullable|array',
            'ttd_admin'         => 'nullable|string',
            'tanggal_admin'     => 'nullable|date'
        ]);

        // 1. Update memenuhi_syarat setiap dokumen (sebelum menentukan status)
        $hasUnmet = false;
        if ($request->has('syarat')) {
            foreach ($request->syarat as $idDokumen => $nilai) {
                if (is_numeric($idDokumen)) {
                    $memenuhi = $nilai === 'Ya' ? 1 : 0;
                    if ($memenuhi == 0) {
                        $hasUnmet = true;
                    }
                    DB::table('dokumen_persyaratan')
                        ->where('id_dokumen', $idDokumen)
                        ->update([
                            'memenuhi_syarat' => $memenuhi,
                            'updated_at'      => now(),
                        ]);
                }
            }
        }

        // 2. Tentukan status akhir permohonan
        $finalStatus = $request->status_permohonan;
        if ($hasUnmet && $finalStatus === 'Diterima') {
            $finalStatus = 'Ditolak';
            // Kirim pesan flash peringatan
            session()->flash('warning', 'Terdapat dokumen yang tidak memenuhi syarat. Status permohonan otomatis diubah menjadi Ditolak.');
        }

        // 3. Update status permohonan
        $adminId = DB::table('admin')->where('user_id', Auth::id())->value('id_admin');
        DB::table('permohonan')
            ->where('id_permohonan', $id_permohonan)
            ->update([
                'status'     => $finalStatus,
                'catatan'    => $request->catatan,
                'id_admin'   => $adminId,
                'updated_at' => now(),
            ]);

        // 4. Simpan tanda tangan admin (jika ada)
        if ($request->filled('ttd_admin')) {
            $imageData = str_replace('data:image/png;base64,', '', $request->ttd_admin);
            $imageData = str_replace(' ', '+', $imageData);
            $fileName = 'ttd_admin_' . time() . '.png';
            $filePath = 'tanda_tangan/' . $fileName;
            Storage::disk('public')->put($filePath, base64_decode($imageData));

            DB::table('permohonan_persetujuan')
                ->updateOrInsert(
                    ['id_permohonan' => $id_permohonan],
                    [
                        'tgl_ttd_admin' => $request->tanggal_admin ?? now(),
                        'ttd_admin'      => $filePath,
                        'updated_at'     => now(),
                    ]
                );
        }

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Permohonan berhasil diperbarui.');
    }
}