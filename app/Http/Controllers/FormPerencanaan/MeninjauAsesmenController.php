<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skema;
use App\Models\Asesor;
use Barryvdh\DomPDF\Facade\Pdf;

class MeninjauAsesmenController extends Controller
{
    /**
     * Download PDF FR.AK.06 untuk Admin
     */
    public function downloadPdfAdmin($skema_id, $asesor_id)
    {
        // Ambil data asesor
        $asesor = DB::table('asesor')->where('id_asesor', $asesor_id)->first();

        // Ambil skema
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $skema_id)->first();

        // Ambil data TUK (sementara ambil yang pertama / aktif)
        $tuk = DB::table('tuk')->where('status_tuk', 'Aktif')->first();

        // Ambil data meninjau asesmen
        $meninjau = DB::table('meninjau_asesmen')
            ->where('asesor_id', $asesor_id)
            ->where('skema_id', $skema_id)
            ->first();

        // Ambil data catatan & tanda tangan dari tabel penyusun_persetujuan
        $penyusun = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->where('id_asesor', $asesor_id)
            ->where('role', 'asesor')
            ->first();

        $view = 'form_perencanaan.admin_formperencanaan.meninjau-pdf';

        // Generate PDF
        $pdf = Pdf::loadView($view, compact('asesor', 'skema', 'tuk', 'meninjau', 'penyusun'))
            ->setPaper('a4', 'portrait');

        $filename = 'Meninjau_Proses_Asesmen_' . ($asesor->nama_asesor ?? 'unknown') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Tampilan Admin untuk melihat FR.AK.06 (View Only)
     */
    public function showAdmin($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $id_skema)
            ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi')
            ->get();

        return view('form_perencanaan.admin_formperencanaan.meninjau-admin', compact('skema', 'asesors'));
    }

    /**
     * Halaman awal meninjau asesmen (pilih skema & isi form)
     */
    public function showNinjauAsesmen($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $asesors = DB::table('asesor_skema')
            ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
            ->where('asesor_skema.skema_id', $id_skema)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        $asesor_terpilih = request()->query('asesor_id') 
            ?? session('asesor_terpilih') 
            ?? ($asesors->first()->id_asesor ?? null);


        $meninjau = DB::table('meninjau_asesmen')
            ->where('skema_id', $id_skema)
            ->where('asesor_id', $asesor_terpilih)
            ->first();

        return view(
            'form_perencanaan.meninjau_asesmen.ninjau_asesmen',
            compact('skema','asesors','asesor_terpilih','meninjau')
        );
    }

    /**
     * Halaman tanda tangan asesor (halaman 2)
     */
    public function showNinjauAsesmenAsesor($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        // Ambil semua asesor terkait skema
        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $id_skema)
            ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi as no_met')
            ->get();

        // Ambil asesor yang dipilih dari query string atau fallback ke pertama
        $asesor_terpilih = request()->query('asesor_id') 
            ?? session('asesor_terpilih') 
            ?? ($asesors->first()->id_asesor ?? null);

        // Ambil data TTD
        $ttd = DB::table('penyusun_persetujuan')
            ->where('id_skema', $id_skema)
            ->where('id_asesor', $asesor_terpilih)
            ->where('role', 'asesor')
            ->first();

        $no_registrasi_terpilih = $ttd->no_met ?? optional($asesors->firstWhere('id_asesor', $asesor_terpilih))->no_met;

        return view('form_perencanaan.meninjau_asesmen.ninjau_asesmen_asesor', compact(
            'skema',
            'asesors',
            'asesor_terpilih',
            'ttd',
            'no_registrasi_terpilih'
        ));
    }

    /**
     * Ambil data meninjau asesmen berdasarkan asesor & skema (AJAX untuk Admin)
     */
    public function getDataByAsesor($skema_id, $asesor_id)
    {
        $meninjau = DB::table('meninjau_asesmen')
            ->where('skema_id', $skema_id)
            ->where('asesor_id', $asesor_id)
            ->first();

        // Ambil data catatan & tanda tangan
        $penyusun = DB::table('penyusun_persetujuan')
            ->where('id_skema', $skema_id)
            ->where('id_asesor', $asesor_id)
            ->where('role', 'asesor')
            ->first();

        // Format data prinsip asesmen
        $prinsip = [];
        if ($meninjau) {
            $prinsip = [
                'rencana_validitas' => $meninjau->rencana_valid ?? false,
                'rencana_reliabel' => $meninjau->rencana_reliabel ?? false,
                'rencana_fleksibel' => $meninjau->rencana_fleksibel ?? false,
                'rencana_adil' => $meninjau->rencana_adil ?? false,

                'persiapan_validitas' => $meninjau->persiapan_valid ?? false,
                'persiapan_reliabel' => $meninjau->persiapan_reliabel ?? false,
                'persiapan_fleksibel' => $meninjau->persiapan_fleksibel ?? false,
                'persiapan_adil' => $meninjau->persiapan_adil ?? false,

                'implementasi_validitas' => $meninjau->implementasi_valid ?? false,
                'implementasi_reliabel' => $meninjau->implementasi_reliabel ?? false,
                'implementasi_fleksibel' => $meninjau->implementasi_fleksibel ?? false,
                'implementasi_adil' => $meninjau->implementasi_adil ?? false,

                'keputusan_validitas' => $meninjau->keputusan_valid ?? false,
                'keputusan_reliabel' => $meninjau->keputusan_reliabel ?? false,
                'keputusan_fleksibel' => $meninjau->keputusan_fleksibel ?? false,
                'keputusan_adil' => $meninjau->keputusan_adil ?? false,

                'umpan_validitas' => $meninjau->umpan_valid ?? false,
                'umpan_reliabel' => $meninjau->umpan_reliabel ?? false,
                'umpan_fleksibel' => $meninjau->umpan_fleksibel ?? false,
                'umpan_adil' => $meninjau->umpan_adil ?? false,
            ];
        }

        // Format data dimensi kompetensi
        $dimensi = [];
        if ($meninjau) {
            $dimensi = [
                'konsistensi_task' => $meninjau->konsistensi_task ? explode(',', $meninjau->konsistensi_task) : [],
                'konsistensi_task_mgmt' => $meninjau->konsistensi_task_mgmt ? explode(',', $meninjau->konsistensi_task_mgmt) : [],
                'konsistensi_contingency' => $meninjau->konsistensi_contingency ? explode(',', $meninjau->konsistensi_contingency) : [],
                'konsistensi_jobrole' => $meninjau->konsistensi_jobrole ? explode(',', $meninjau->konsistensi_jobrole) : [],
                'konsistensi_transfer' => $meninjau->konsistensi_transfer ? explode(',', $meninjau->konsistensi_transfer) : [],

                'bukti_task' => $meninjau->bukti_task ? explode(',', $meninjau->bukti_task) : [],
                'bukti_task_mgmt' => $meninjau->bukti_task_mgmt ? explode(',', $meninjau->bukti_task_mgmt) : [],
                'bukti_contingency' => $meninjau->bukti_contingency ? explode(',', $meninjau->bukti_contingency) : [],
                'bukti_jobrole' => $meninjau->bukti_jobrole ? explode(',', $meninjau->bukti_jobrole) : [],
                'bukti_transfer' => $meninjau->bukti_transfer ? explode(',', $meninjau->bukti_transfer) : [],
            ];
        }

        return response()->json([
            'prinsip' => $prinsip,
            'dimensi' => $dimensi,
            'rekomendasi1' => $meninjau->rekomendasi1 ?? '',
            'rekomendasi2' => $meninjau->rekomendasi2 ?? '',
            'tanda_tangan' => [
                'catatan' => $penyusun->catatan ?? '',
                'tanggal' => $meninjau->created_at ?? '',
                'tanda_tangan' => $penyusun->tanda_tangan ?? '',
            ]
        ]);
    }

    /**
     * Simpan hasil review asesmen (halaman 1)
     */
    public function store(Request $request, $id_skema)
    {
        $asesorId = $request->asesor_id;

        // Implode checkbox array menjadi string
        $konsistensi_task = implode(',', $request->input('konsistensi_task', []));
        $konsistensi_task_mgmt = implode(',', $request->input('konsistensi_task_mgmt', []));
        $konsistensi_contingency = implode(',', $request->input('konsistensi_contingency', []));
        $konsistensi_jobrole = implode(',', $request->input('konsistensi_jobrole', []));
        $konsistensi_transfer = implode(',', $request->input('konsistensi_transfer', []));

        $bukti_task = implode(',', $request->input('bukti_task', []));
        $bukti_task_mgmt = implode(',', $request->input('bukti_task_mgmt', []));
        $bukti_contingency = implode(',', $request->input('bukti_contingency', []));
        $bukti_jobrole = implode(',', $request->input('bukti_jobrole', []));
        $bukti_transfer = implode(',', $request->input('bukti_transfer', []));

        DB::table('meninjau_asesmen')->updateOrInsert(
            [
                'skema_id' => $id_skema,
                'asesor_id' => $asesorId,
            ],
            [
                // Rencana Asesmen
                'rencana_valid' => $request->has('rencana_valid'),
                'rencana_reliabel' => $request->has('rencana_reliabel'),
                'rencana_fleksibel' => $request->has('rencana_fleksibel'),
                'rencana_adil' => $request->has('rencana_adil'),

                // Persiapan
                'persiapan_valid' => $request->has('persiapan_valid'),
                'persiapan_reliabel' => $request->has('persiapan_reliabel'),
                'persiapan_fleksibel' => $request->has('persiapan_fleksibel'),
                'persiapan_adil' => $request->has('persiapan_adil'),

                // Implementasi
                'implementasi_valid' => $request->has('implementasi_valid'),
                'implementasi_reliabel' => $request->has('implementasi_reliabel'),
                'implementasi_fleksibel' => $request->has('implementasi_fleksibel'),
                'implementasi_adil' => $request->has('implementasi_adil'),

                // Keputusan
                'keputusan_valid' => $request->has('keputusan_valid'),
                'keputusan_reliabel' => $request->has('keputusan_reliabel'),
                'keputusan_fleksibel' => $request->has('keputusan_fleksibel'),
                'keputusan_adil' => $request->has('keputusan_adil'),

                // Umpan balik
                'umpan_valid' => $request->has('umpan_valid'),
                'umpan_reliabel' => $request->has('umpan_reliabel'),
                'umpan_fleksibel' => $request->has('umpan_fleksibel'),
                'umpan_adil' => $request->has('umpan_adil'),

                // Rekomendasi 1
                'rekomendasi1' => $request->rekomendasi1,

                // Konsistensi
                'konsistensi_task' => $konsistensi_task,
                'konsistensi_task_mgmt' => $konsistensi_task_mgmt,
                'konsistensi_contingency' => $konsistensi_contingency,
                'konsistensi_jobrole' => $konsistensi_jobrole,
                'konsistensi_transfer' => $konsistensi_transfer,

                // Bukti
                'bukti_task' => $bukti_task,
                'bukti_task_mgmt' => $bukti_task_mgmt,
                'bukti_contingency' => $bukti_contingency,
                'bukti_jobrole' => $bukti_jobrole,
                'bukti_transfer' => $bukti_transfer,

                // Rekomendasi 2
                'rekomendasi2' => $request->rekomendasi2,

                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return redirect()
            ->route('form_perencanaan.meninjau_asesmen.ninjau_asesmen_asesor', $id_skema)
            ->with('success', 'Data meninjau asesmen berhasil disimpan')
            ->with('asesor_terpilih', $asesorId);
    }

    /**
     * Simpan tanda tangan asesor (halaman 2)
     */
    public function storeAsesor(Request $request, $id_skema)
    {
        $asesorId = $request->asesor_id;

        DB::table('penyusun_persetujuan')->updateOrInsert(
            [
                'id_skema' => $id_skema,
                'id_asesor' => $asesorId,
                'role' => 'asesor',
            ],
            [
                'catatan' => $request->catatan,
                'tanda_tangan' => $request->tanda_tangan,
                'no_met' => $request->no_registrasi ?? '',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Tanda tangan berhasil disimpan'
        ]);
    }

    /**
     * Download TTD Asesor
     */
    public function downloadTtd($id)
    {
        $ttd = DB::table('penyusun_persetujuan')->where('id', $id)->first();
        
        if (!$ttd || !$ttd->tanda_tangan) {
            return back()->with('error', 'Tanda tangan tidak ditemukan');
        }

        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $ttd->tanda_tangan));
        
        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="ttd_asesor.png"');
    }

    /**
     * Hapus TTD Asesor
     */
    public function deleteTtd($id)
    {
        try {
            DB::table('penyusun_persetujuan')
                ->where('id', $id)
                ->update([
                    'tanda_tangan' => null,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Tanda tangan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tanda tangan'
            ], 500);
        }
    }

    /**
     * Ambil asesor berdasarkan skema (AJAX)
     */
    public function getAsesor($skema_id)
    {
        $asesors = DB::table('asesor_skema')
            ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        return response()->json($asesors);
    }
    public function simpanLanjut(Request $request, $id_skema)
{
    $asesorId = $request->asesor_id;

    // Validasi
    if (!$asesorId) {
        return back()->with('error', 'Pilih asesor terlebih dahulu');
    }

    // Implode checkbox array menjadi string
    $konsistensi_task = implode(',', $request->input('konsistensi_task', []));
    $konsistensi_task_mgmt = implode(',', $request->input('konsistensi_task_mgmt', []));
    $konsistensi_contingency = implode(',', $request->input('konsistensi_contingency', []));
    $konsistensi_jobrole = implode(',', $request->input('konsistensi_jobrole', []));
    $konsistensi_transfer = implode(',', $request->input('konsistensi_transfer', []));

    $bukti_task = implode(',', $request->input('bukti_task', []));
    $bukti_task_mgmt = implode(',', $request->input('bukti_task_mgmt', []));
    $bukti_contingency = implode(',', $request->input('bukti_contingency', []));
    $bukti_jobrole = implode(',', $request->input('bukti_jobrole', []));
    $bukti_transfer = implode(',', $request->input('bukti_transfer', []));

    // Simpan ke tabel meninjau_asesmen
    DB::table('meninjau_asesmen')->updateOrInsert(
        [
            'skema_id' => $id_skema,
            'asesor_id' => $asesorId,
        ],
        [
            'rencana_valid' => $request->has('rencana_valid'),
            'rencana_reliabel' => $request->has('rencana_reliabel'),
            'rencana_fleksibel' => $request->has('rencana_fleksibel'),
            'rencana_adil' => $request->has('rencana_adil'),

            'persiapan_valid' => $request->has('persiapan_valid'),
            'persiapan_reliabel' => $request->has('persiapan_reliabel'),
            'persiapan_fleksibel' => $request->has('persiapan_fleksibel'),
            'persiapan_adil' => $request->has('persiapan_adil'),

            'implementasi_valid' => $request->has('implementasi_valid'),
            'implementasi_reliabel' => $request->has('implementasi_reliabel'),
            'implementasi_fleksibel' => $request->has('implementasi_fleksibel'),
            'implementasi_adil' => $request->has('implementasi_adil'),

            'keputusan_valid' => $request->has('keputusan_valid'),
            'keputusan_reliabel' => $request->has('keputusan_reliabel'),
            'keputusan_fleksibel' => $request->has('keputusan_fleksibel'),
            'keputusan_adil' => $request->has('keputusan_adil'),

            'umpan_valid' => $request->has('umpan_valid'),
            'umpan_reliabel' => $request->has('umpan_reliabel'),
            'umpan_fleksibel' => $request->has('umpan_fleksibel'),
            'umpan_adil' => $request->has('umpan_adil'),

            'rekomendasi1' => $request->rekomendasi1,

            'konsistensi_task' => $konsistensi_task,
            'konsistensi_task_mgmt' => $konsistensi_task_mgmt,
            'konsistensi_contingency' => $konsistensi_contingency,
            'konsistensi_jobrole' => $konsistensi_jobrole,
            'konsistensi_transfer' => $konsistensi_transfer,

            'bukti_task' => $bukti_task,
            'bukti_task_mgmt' => $bukti_task_mgmt,
            'bukti_contingency' => $bukti_contingency,
            'bukti_jobrole' => $bukti_jobrole,
            'bukti_transfer' => $bukti_transfer,

            'rekomendasi2' => $request->rekomendasi2,

            'updated_at' => now(),
            'created_at' => now(),
        ]
    );

    // PERBAIKAN DI SINI: Redirect ke route GET halaman 2, bukan POST
    return redirect()
        ->route('form_perencanaan.ninjau_asesmen_asesor', $id_skema)
        ->with('success', 'Data berhasil disimpan')
        ->with('asesor_terpilih', $asesorId);
}
}