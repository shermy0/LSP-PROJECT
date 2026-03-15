<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesi;
use App\Models\SkemaSertifikasi;
use App\Models\KelompokPekerjaan;
use App\Models\Kuk;
use App\Models\ObservasiCeklis;
use App\Models\ObservasiCeklisItem;
use App\Models\ObservasiCeklisPersetujuan;

class CeklisObservasiController extends Controller
{
    /**
     * Halaman utama form ceklis observasi
     */
    public function index(Request $request)
    {
        $idAsesi = $request->get('id_asesi');
        $idSkema = $request->get('id_skema');

        if (!$idAsesi || !$idSkema) {
            return redirect()->route('ceklisobservasi.pilih', ['id_skema' => $idSkema ?? 0])
                ->with('error', 'Silakan pilih asesi terlebih dahulu.');
        }

        $asesi = Asesi::findOrFail($idAsesi);

        // Ambil observasi terbaru untuk asesi & skema ini (jika ada)
        $observasi = ObservasiCeklis::with(['items', 'persetujuan'])
            ->where('id_asesi', $idAsesi)
            ->where('id_skema', $idSkema)
            ->orderBy('id_observasi', 'desc')
            ->first();

        // Ambil data kelompok pekerjaan beserta unit, elemen, KUK
        $kelompok = KelompokPekerjaan::with(['unitKompetensi.elemen.kuk'])
            ->where('id_skema', $idSkema)
            ->get();

        // Buat map existing items untuk memudahkan pre-fill di view
        $existingItems = [];
        if ($observasi) {
            foreach ($observasi->items as $item) {
                $existingItems[$item->id_kuk] = $item;
            }
        }

        return view('ceklis_observasi', compact('asesi', 'observasi', 'kelompok', 'existingItems'));
    }

    public function pilihAsesi($id_skema)
    {
        $skema = SkemaSertifikasi::findOrFail($id_skema);
    
        $asesor = auth()->user()->asesor;
        if (!$asesor) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar sebagai asesor.');
        }
    
        // Ambil asesi yang berada di bawah asesor ini
        $asesi = Asesi::where('asesor_id', $asesor->id_asesor)->get();
    
        // Ambil semua observasi untuk skema ini beserta persetujuan
        $observasiList = ObservasiCeklis::where('id_skema', $id_skema)
            ->with('persetujuan')
            ->get();
    
        // Inisialisasi array status
        $signatureAsesorStatus = [];
        $signatureAsesiStatus = [];
    
        foreach ($observasiList as $obs) {
            if ($obs->persetujuan) {
                if ($obs->persetujuan->ttd_asesor) {
                    $signatureAsesorStatus[$obs->id_asesi] = true;
                }
                if ($obs->persetujuan->ttd_asesi) {
                    $signatureAsesiStatus[$obs->id_asesi] = true;
                }
            }
        }
    
        // Pastikan semua asesi tercakup (default false)
        foreach ($asesi as $a) {
            if (!isset($signatureAsesorStatus[$a->id_asesi])) {
                $signatureAsesorStatus[$a->id_asesi] = false;
            }
            if (!isset($signatureAsesiStatus[$a->id_asesi])) {
                $signatureAsesiStatus[$a->id_asesi] = false;
            }
        }
    
        return view('listasesiceklisobservasi', compact(
            'skema',
            'asesi',
            'signatureAsesorStatus',
            'signatureAsesiStatus'
        ));
    }

    /**
     * Load data dinamis (KUK dan kelompok kerja berdasarkan skema)
     * Masih dipertahankan untuk kebutuhan lain (jika ada)
     */
    public function loadData($skemaId)
    {
        $skema = SkemaSertifikasi::find($skemaId);
        $kelompok = KelompokPekerjaan::with(['unitKompetensi.elemen.kuk'])
            ->where('id_skema', $skemaId)
            ->get();

        return response()->json([
            'skema_nama' => $skema?->nama_skema,
            'kelompok'   => $kelompok,
        ]);
    }

    /**
     * Simpan hasil observasi ke database (create or update)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_asesi'     => 'required|exists:asesi,id_asesi',
                'id_skema'     => 'required|exists:skema_sertifikasi,id_skema',
                'id_observasi' => 'nullable|exists:observasi_ceklis,id_observasi',
                'kuk'          => 'required|array',
                'ttd_asesor'   => 'nullable|string', // boleh kosong jika tidak ingin ubah ttd
                'umpan_balik'  => 'nullable|string',
                'rekomendasi'  => 'nullable|string|in:Kompeten,Belum Kompeten',
                'rekomendasi_rincian' => 'nullable|string',
            ]);

            $idAsesor = auth()->user()->asesor->id_asesor ?? null;
            if (!$idAsesor) {
                return back()->with('error', 'Asesor tidak ditemukan.');
            }

            // Cari observasi existing atau buat baru
            $observasi = null;
            if (!empty($validated['id_observasi'])) {
                $observasi = ObservasiCeklis::find($validated['id_observasi']);
            }
            if (!$observasi) {
                // Coba cari berdasarkan asesi & skema (jika ingin hanya satu per pasangan)
                $observasi = ObservasiCeklis::where('id_asesi', $validated['id_asesi'])
                    ->where('id_skema', $validated['id_skema'])
                    ->first();
            }

            $dataObservasi = [
                'id_skema' => $validated['id_skema'],
                'id_asesor' => $idAsesor,
                'id_asesi' => $validated['id_asesi'],
                'umpan_balik' => $validated['umpan_balik'] ?? null,
                'rekomendasi' => $validated['rekomendasi'] ?? null,
                'rekomendasi_rincian' => $validated['rekomendasi_rincian'] ?? null,
            ];

            if ($observasi) {
                // Update
                $observasi->update($dataObservasi);
                // Hapus item lama, nanti insert ulang
                ObservasiCeklisItem::where('id_observasi', $observasi->id_observasi)->delete();
            } else {
                // Buat baru
                $observasi = ObservasiCeklis::create($dataObservasi);
            }

            // Simpan item observasi
            foreach ($validated['kuk'] as $kukId => $row) {
                $kukModel = Kuk::with('elemen.unit')->findOrFail($kukId);
                ObservasiCeklisItem::create([
                    'id_observasi' => $observasi->id_observasi,
                    'id_skema' => $validated['id_skema'],
                    'id_unit' => $kukModel->elemen->id_unit,
                    'id_elemen' => $kukModel->id_elemen,
                    'id_kuk' => $kukModel->id_kuk,
                    'standar_industri' => $row['standar_industri'] ?? 'Modul Praktek',
                    'pencapaian' => $row['status'] ?? null,
                    'penilaian_lanjut' => $row['catatan'] ?? null,
                ]);
            }

            // Handle tanda tangan
            $persetujuan = ObservasiCeklisPersetujuan::firstOrNew(
                ['id_observasi' => $observasi->id_observasi]
            );

            // Jika ada ttd baru dari canvas
            if (!empty($validated['ttd_asesor'])) {
                $image_parts = explode(";base64,", $validated['ttd_asesor']);
                if (count($image_parts) < 2) {
                    return back()->with('error', 'Format tanda tangan tidak valid.');
                }
                $image_base64 = base64_decode($image_parts[1]);
                if ($image_base64 === false) {
                    return back()->with('error', 'Gagal mendekode base64.');
                }

                // Gunakan disk 'public' agar file dapat diakses dari storage/app/public
                $folder = 'ttd';
                if (!Storage::disk('public')->exists($folder)) {
                    Storage::disk('public')->makeDirectory($folder);
                }

                $fileName = 'ttd_asesor_' . time() . '.png';
                $filePath = $folder . '/' . $fileName;

                if (!Storage::disk('public')->put($filePath, $image_base64)) {
                    return back()->with('error', 'Gagal menyimpan file tanda tangan.');
                }

                // Hapus file lama jika ada
                if ($persetujuan->exists && $persetujuan->ttd_asesor) {
                    $oldFilePath = $folder . '/' . $persetujuan->ttd_asesor;
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                    }
                }

                $persetujuan->ttd_asesor = $fileName;
                $persetujuan->tgl_ttd_asesor = now();
            }

            // Jika persetujuan sudah ada (misal hanya update ttd) atau baru, simpan
            if ($persetujuan->isDirty() || !$persetujuan->exists) {
                $persetujuan->save();
            }

            return redirect()->route('ceklisobservasi.index', [
                'id_skema' => $validated['id_skema'],
                'id_asesi' => $validated['id_asesi']
            ])->with('success', 'Data observasi berhasil disimpan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tandatangan($id)
    {
        $observasi = ObservasiCeklis::with([
            'asesi',
            'skema',
            'asesor',
            'items.unit',
            'items.elemen',
            'items.kuk',
            'persetujuan'
        ])->findOrFail($id);

        return view('ceklis_observasi_tandatangan', compact('observasi'));
    }

    // Menyimpan tanda tangan asesi
    public function storeTandatangan(Request $request)
    {
        $request->validate([
            'id_observasi' => 'required|exists:observasi_ceklis,id_observasi',
            'ttd_asesi'    => 'required',
            'tgl_ttd_asesi'=> 'required|date',
        ]);

        // Cari record persetujuan yang sudah dibuat saat asesor menyimpan
        $persetujuan = ObservasiCeklisPersetujuan::where('id_observasi', $request->id_observasi)->first();

        if (!$persetujuan) {
            // Jika belum ada, buat baru (misal jika asesor belum sempat simpan ttd)
            $persetujuan = new ObservasiCeklisPersetujuan();
            $persetujuan->id_observasi = $request->id_observasi;
        }

        // Simpan gambar tanda tangan asesi
        $image_parts = explode(";base64,", $request->ttd_asesi);
        if (count($image_parts) < 2) {
            return back()->with('error', 'Format tanda tangan tidak valid.');
        }
        $image_base64 = base64_decode($image_parts[1]);
        if ($image_base64 === false) {
            return back()->with('error', 'Gagal mendekode base64.');
        }

        $folder = 'ttd';
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        $fileName = 'ttd_asesi_' . time() . '.png';
        $filePath = $folder . '/' . $fileName;

        if (!Storage::disk('public')->put($filePath, $image_base64)) {
            return back()->with('error', 'Gagal menyimpan file tanda tangan.');
        }

        // Hapus file lama jika ada
        if ($persetujuan->exists && $persetujuan->ttd_asesi) {
            $oldFilePath = $folder . '/' . $persetujuan->ttd_asesi;
            if (Storage::disk('public')->exists($oldFilePath)) {
                Storage::disk('public')->delete($oldFilePath);
            }
        }

        $persetujuan->tgl_ttd_asesi = $request->tgl_ttd_asesi;
        $persetujuan->ttd_asesi = $fileName;
        $persetujuan->save();

        return redirect()->route('asesi.dashboard') // atau halaman sukses lain
                        ->with('success', 'Tanda tangan asesi berhasil disimpan.');
    }

    public function tandatanganBySkemaAsesi($id_skema, $id_asesi)
    {
        // Ambil observasi terbaru berdasarkan id_observasi (desc)
        $observasi = ObservasiCeklis::where('id_skema', $id_skema)
                    ->where('id_asesi', $id_asesi)
                    ->orderBy('id_observasi', 'desc')
                    ->firstOrFail();

        // Panggil method tandatangan yang sudah ada
        return $this->tandatangan($observasi->id_observasi);
    }

    // Relasi di model ObservasiCeklis (bisa dipindah ke model, tapi ditaruh sini untuk keperluan controller)
    public function persetujuan()
    {
        return $this->hasOne(ObservasiCeklisPersetujuan::class, 'id_observasi');
    }

    public function showTtdAsesor($filename)
    {
        if (!Storage::disk('public')->exists('ttd/' . $filename)) {
            abort(404, 'Tanda tangan tidak ditemukan.');
        }
        
        return Storage::disk('public')->response('ttd/' . $filename);
    }
}