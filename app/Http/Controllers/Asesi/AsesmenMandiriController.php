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
     * Hanya menampilkan dokumen "Fotocopy Raport" dan "Sertifikat PKL" (selain upload file lain)
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

        // ========== PERUBAHAN: Hanya ambil dokumen "Fotocopy Raport" dan "Sertifikat PKL" ==========
        // Sesuaikan id_jenis_dokumen dengan nilai di database Anda
        $dokumenIds = [1, 2]; // Misal: 1 = Fotocopy Raport, 2 = Sertifikat PKL
        // Atau bisa menggunakan nama dokumen:
        // $namaDokumen = ['Fotocopy Raport', 'Sertifikat PKL'];

        $dokumen = DB::table('dokumen_persyaratan')
            ->join('jenis_dokumen', 'dokumen_persyaratan.id_jenis_dokumen', '=', 'jenis_dokumen.id_jenis_dokumen')
            ->where('dokumen_persyaratan.id_permohonan', $permohonan->id_permohonan)
            ->where('dokumen_persyaratan.ada', true)
            ->whereIn('jenis_dokumen.id_jenis_dokumen', $dokumenIds) // filter berdasarkan id
            // ->whereIn('jenis_dokumen.nama_dokumen', $namaDokumen) // alternatif menggunakan nama
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
            // 🔥 PERUBAHAN: Selalu ambil jawaban jika master ada
            $jawaban = DB::table('asesmen_mandiri_jawaban')
                ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                ->get()
                ->keyBy('id_kuk');
        }

        return view(
            'asesi.asesmen_mandiri.form2',
            compact('permohonan', 'units', 'elemen', 'kuk', 'dokumen', 'jawaban', 'rekomendasi')
        );
    }

    /**
     * Simpan jawaban asesmen mandiri (K/BK dan pilihan bukti)
     * Mendukung upload file lain (bukan dari dokumen persyaratan)
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

        $master = DB::table('asesmen_mandiri_master')
            ->where('id_permohonan', $permohonan->id_permohonan)
            ->first();

        DB::beginTransaction();
        try {
            $oldAnswers = collect();

            if ($master) {
                // Ambil jawaban lama sebelum dihapus (untuk mengambil file_lain yang tidak diubah)
                $oldAnswers = DB::table('asesmen_mandiri_jawaban')
                    ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                    ->get()
                    ->keyBy('id_kuk');

                // Hapus jawaban lama
                DB::table('asesmen_mandiri_jawaban')
                    ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                    ->delete();

                // Jika master ada dan rekomendasi = 'Tidak Dapat Dilanjutkan', reset rekomendasi
                if ($master->rekomendasi === 'Tidak Dapat Dilanjutkan') {
                    DB::table('asesmen_mandiri_master')
                        ->where('id_asesmen_mandiri', $master->id_asesmen_mandiri)
                        ->update([
                            'rekomendasi' => null,
                            'id_asesor' => null,
                        ]);
                }
                $idAsesmen = $master->id_asesmen_mandiri;
            } else {
                // Buat master baru
                $idAsesmen = DB::table('asesmen_mandiri_master')->insertGetId([
                    'id_permohonan' => $permohonan->id_permohonan,
                    'id_asesi' => $asesi->id_asesi,
                    'id_asesor' => null,
                    'rekomendasi' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $jawabanKuk = $request->input('kuk', []);
            $dokumenKuk = $request->input('bukti', []);

            foreach ($jawabanKuk as $id_kuk => $status) {
                $idDokumen = $dokumenKuk[$id_kuk] ?? null;
                $fileLain = null;
                $hapusFileLain = $request->input("hapus_file_lain.$id_kuk", 0);

                // Jika pilih upload_lain
                if ($idDokumen === 'upload_lain') {
                    $idDokumen = null;
                    // Cek apakah ada file baru diupload
                    if ($request->hasFile("file_lain.$id_kuk")) {
                        $file = $request->file("file_lain.$id_kuk");
                        $path = $file->store("bukti_asesmen_mandiri", 'public');
                        $fileLain = $path;
                    } else {
                        // Tidak ada file baru, cek apakah ada file lama dan tidak dihapus
                        if ($hapusFileLain != 1 && $oldAnswers->has($id_kuk) && $oldAnswers[$id_kuk]->file_lain) {
                            $fileLain = $oldAnswers[$id_kuk]->file_lain;
                        }
                    }
                } else {
                    // Jika pilih dokumen biasa, pastikan file_lain dihapus jika ada
                    if ($oldAnswers->has($id_kuk) && $oldAnswers[$id_kuk]->file_lain) {
                        // Hapus file fisik jika ada
                        Storage::disk('public')->delete($oldAnswers[$id_kuk]->file_lain);
                    }
                    $fileLain = null;
                }

                DB::table('asesmen_mandiri_jawaban')->insert([
                    'id_asesmen_mandiri' => $idAsesmen,
                    'id_kuk' => $id_kuk,
                    'status' => $status,
                    'id_dokumen' => $idDokumen,
                    'file_lain' => $fileLain,
                    'created_at' => now(),
                    'updated_at' => now(),
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