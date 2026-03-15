<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AsesmenMandiriController extends Controller
{
    /**
     * Tampilkan halaman pertama asesmen mandiri (informasi skema)
     */
    public function form1()
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Data asesi tidak ditemukan, lengkapi permohonan terlebih dahulu.');
        }

        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.id_asesi', $asesi->id_asesi)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.id_skema',
                'skema_sertifikasi.nama_skema as skema',
                'skema_sertifikasi.kode_skema',
                'skema_sertifikasi.judul_skema'
            )
            ->latest('permohonan.id_permohonan')
            ->first();

        return view('asesi.asesmen_mandiri.form1', compact('permohonan'));
    }

    /**
     * Tampilkan halaman kedua: daftar unit kompetensi, elemen, KUK, dan pilihan bukti
     * Jika ada asesmen mandiri sebelumnya dengan rekomendasi 'Tidak Dapat Dilanjutkan', maka data lama ditampilkan (mode edit)
     */
    public function form2()
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Data asesi tidak ditemukan.');
        }

        $permohonan = DB::table('permohonan')
            ->join('skema_sertifikasi', 'permohonan.id_skema', '=', 'skema_sertifikasi.id_skema')
            ->where('permohonan.id_asesi', $asesi->id_asesi)
            ->select(
                'permohonan.id_permohonan',
                'permohonan.id_skema',
                'skema_sertifikasi.nama_skema',
                'skema_sertifikasi.kode_skema',
                'skema_sertifikasi.judul_skema'
            )
            ->latest('permohonan.id_permohonan')
            ->first();

        if (!$permohonan) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Anda belum mengajukan permohonan.');
        }

        // Ambil unit, elemen, kuk
        $units = DB::table('unit_kompetensi')
            ->where('id_skema', $permohonan->id_skema)
            ->get();

        $elemen = DB::table('elemen_kompetensi')
            ->whereIn('id_unit', $units->pluck('id_unit')->toArray())
            ->select('id_elemen', 'id_unit', 'nama_elemen as judul_elemen')
            ->get();

        $kuk = DB::table('kuk')
            ->whereIn('id_elemen', $elemen->pluck('id_elemen')->toArray())
            ->get();

        // Ambil dokumen pendukung (contoh: rapor, sertifikat PKL) - sesuaikan id_jenis_dokumen dengan kebutuhan
        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.id_jenis_dokumen', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.id_permohonan', $permohonan->id_permohonan)
            ->whereIn('dokumen_persyaratan.id_jenis_dokumen', [1, 2]) // Sesuaikan
            ->select(
                'dokumen_persyaratan.id_dokumen',
                'dokumen_persyaratan.path_file as file_path',
                'dokumen_persyaratan.nama_file',
                'jenis_dokumen.nama_dokumen as nama_jenis'
            )
            ->get();

        // Cek apakah sudah ada master asesmen mandiri
        $master = DB::table('asesmen_mandiri_master')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        $jawaban = [];
        $rekomendasi = null;

        if ($master) {
            $rekomendasi = $master->rekomendasi;
            // Jika rekomendasi 'Tidak Dapat Dilanjutkan', ambil jawaban lama untuk ditampilkan (mode edit)
            if ($master->rekomendasi === 'Tidak Dapat Dilanjutkan') {
                $jawaban = DB::table('asesmen_mandiri_jawaban')
                    ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                    ->get()
                    ->keyBy('id_kuk');
            }
        }

        return view(
            'asesi.asesmen_mandiri.form2',
            compact('permohonan', 'units', 'elemen', 'kuk', 'dokumen', 'jawaban', 'rekomendasi')
        );
    }

    /**
     * Simpan jawaban asesmen mandiri (K/BK dan pilihan bukti)
     * Jika sudah ada master dengan rekomendasi 'Tidak Dapat Dilanjutkan', data lama dihapus dan diganti dengan yang baru, serta rekomendasi direset.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Data asesi tidak ditemukan.');
        }

        $permohonan = DB::table('permohonan')
            ->where('id_asesi', $asesi->id_asesi)
            ->latest('id_permohonan')
            ->first();

        if (!$permohonan) {
            return redirect()->route('asesi.permohonan.form1')
                ->with('error', 'Anda belum mengajukan permohonan.');
        }

        // Cek apakah sudah ada master asesmen mandiri
        $master = DB::table('asesmen_mandiri_master')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        DB::beginTransaction();
        try {
            $idAsesmen = null;
            if ($master) {
                // Jika ada master dan rekomendasi = 'Tidak Dapat Dilanjutkan', hapus jawaban lama dan reset rekomendasi
                if ($master->rekomendasi === 'Tidak Dapat Dilanjutkan') {
                    // Hapus jawaban lama (tabel asesmen_mandiri_jawaban)
                    DB::table('asesmen_mandiri_jawaban')
                        ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                        ->delete();

                    // Reset rekomendasi dan id_asesor
                    DB::table('asesmen_mandiri_master')
                        ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                        ->update([
                            'rekomendasi' => null,
                            'id_asesor' => null,
                            // Tidak ada updated_at di tabel, jadi hapus
                        ]);
                    $idAsesmen = $master->id_asesmen_mandiri;
                } else {
                    // Jika master sudah ada tapi bukan ditolak, kita tetap bisa update (misal asesi ingin mengubah jawaban sebelum diverifikasi)
                    // Hapus jawaban lama lalu insert baru
                    DB::table('asesmen_mandiri_jawaban')
                        ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                        ->delete();
                    $idAsesmen = $master->id_asesmen_mandiri;
                }
            } else {
                // Belum ada master, buat baru
                $idAsesmen = DB::table('asesmen_mandiri_master')->insertGetId([
                    'id_permohonan' => $permohonan->id_permohonan,
                    'id_asesi' => $asesi->id_asesi,
                    'id_asesor' => null,
                    'rekomendasi' => null,
                    // Jika tidak ada timestamps, jangan sertakan
                ]);
            }

            // Simpan jawaban baru
            $jawabanKuk = $request->input('kuk', []);
            $dokumenKuk = $request->input('bukti', []); // bukti berupa id_dokumen dari tabel dokumen_persyaratan

            foreach ($jawabanKuk as $id_kuk => $status) {
                DB::table('asesmen_mandiri_jawaban')->insert([
                    'id_asesmen_mandiri' => $idAsesmen,
                    'id_kuk' => $id_kuk,
                    'status' => $status,
                    'id_dokumen' => $dokumenKuk[$id_kuk] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('asesi.asesmen_mandiri.form3')
                ->with('success', 'Jawaban berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman ketiga (tanda tangan)
     */
    public function form3()
    {
        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        return view('asesi.asesmen_mandiri.form3', compact('asesi'));
    }

    /**
     * Simpan tanda tangan asesi
     */
    public function storeTTD(Request $request)
    {
        $request->validate([
            'ttd_asesi' => 'required|string',
            'tgl_ttd_asesi' => 'required|date',
        ]);

        $user = Auth::user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        if (!$asesi) {
            return redirect()->back()->with('error', 'Data asesi tidak ditemukan.');
        }

        $master = DB::table('asesmen_mandiri_master')
            ->where('id_asesi', $asesi->id_asesi)
            ->latest('id_asesmen_mandiri')
            ->first();

        if (!$master) {
            return redirect()->back()->with('error', 'Data asesmen mandiri belum ada.');
        }

        $data = $request->ttd_asesi;
        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $data);
        $imageName = 'ttd_asesi_' . time() . '.png';

        Storage::disk('public')->put('ttd/' . $imageName, base64_decode($image));

        $persetujuan = DB::table('asesmen_mandiri_persetujuan')
            ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
            ->first();

        if ($persetujuan) {
            DB::table('asesmen_mandiri_persetujuan')
                ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                ->update([
                    'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                    'ttd_asesi' => 'ttd/' . $imageName,
                ]);
        } else {
            DB::table('asesmen_mandiri_persetujuan')->insert([
                'id_asesmen_mandiri' => $master->id_asesmen_mandiri,
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi' => 'ttd/' . $imageName,
                'status_persetujuan' => 'menunggu',
            ]);
        }

        return redirect()->route('form_pra_assesmen')
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }
}