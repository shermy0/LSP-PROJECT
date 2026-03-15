<?php

namespace App\Http\Controllers;

use App\Models\OpsiJawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpsiJawabanController extends Controller
{
    /**
     * Menyimpan opsi jawaban untuk pertanyaan
     */
    public function store(Request $request)
{
    $request->validate([
        'id_pertanyaan' => 'required|exists:pertanyaan,id_pertanyaan',
        'opsi_jawaban' => 'required|array|min:2',
        'opsi_jawaban.*' => 'required|string',
        'kunci_jawaban' => 'required|string'
    ]);

    try {
        DB::beginTransaction();

        $idPertanyaan = $request->id_pertanyaan;
        $opsiJawaban = $request->opsi_jawaban;
        $kunciJawaban = $request->kunci_jawaban;

        // Hapus opsi lama
        OpsiJawaban::where('id_pertanyaan', $idPertanyaan)->delete();

        $kodeOpsi = ['A', 'B', 'C', 'D', 'E'];

        foreach ($opsiJawaban as $index => $isiOpsi) {
            if ($index < 5 && !empty($isiOpsi)) {
                OpsiJawaban::create([
                    'id_pertanyaan' => $idPertanyaan,
                    'kode_opsi'     => $kodeOpsi[$index],
                    'isi_opsi'      => $isiOpsi,
                    'benar'         => $kodeOpsi[$index] == $kunciJawaban ? 1 : 0,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Opsi jawaban berhasil disimpan'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("OpsiJawaban store error: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan opsi jawaban: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Menyimpan multiple opsi jawaban dari form pertanyaan PG
     */
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'id_pertanyaan' => 'required|array',
            'id_pertanyaan.*' => 'required|exists:pertanyaan,id_pertanyaan',
            'kunci_jawaban' => 'required|array'
        ]);
    
        try {
            DB::beginTransaction();
    
            $kodeOpsi = ['A','B','C','D','E'];
    
            foreach ($request->id_pertanyaan as $i => $idPertanyaan) {
    
                // hapus opsi lama
                OpsiJawaban::where('id_pertanyaan', $idPertanyaan)->delete();
    
                for ($j = 0; $j < 5; $j++) {
    
                    $isiOpsi = null;
    
                    // ===== CEK OPSI TEKS =====
                    if (!empty($request->opsi_text[$i][$j])) {
                        $isiOpsi = $request->opsi_text[$i][$j];
                    }
    
                    // ===== CEK OPSI GAMBAR =====
                    if ($request->hasFile("opsi_gambar.$i.$j")) {
    
                        $file = $request->file("opsi_gambar.$i.$j");
    
                        $path = $file->store('opsi_jawaban','public');
    
                        $isiOpsi = $path;
                    }
    
                    // simpan jika ada isi
                    if ($isiOpsi) {
    
                        OpsiJawaban::create([
                            'id_pertanyaan' => $idPertanyaan,
                            'kode_opsi' => $kodeOpsi[$j],
                            'isi_opsi' => $isiOpsi,
                            'benar' => $kodeOpsi[$j] == $request->kunci_jawaban[$i] ? 1 : 0
                        ]);
    
                    }
                }
            }
    
            DB::commit();
    
            return redirect()->back()->with('success','Semua opsi jawaban berhasil disimpan');
    
        } catch (\Exception $e) {
    
            DB::rollBack();
    
            return redirect()->back()->with('error','Gagal menyimpan opsi: '.$e->getMessage());
        }
    }

    /**
     * Mendapatkan opsi jawaban berdasarkan pertanyaan
     */
    public function getByPertanyaan($idPertanyaan)
    {
        try {
            $opsiJawaban = OpsiJawaban::where('id_pertanyaan', $idPertanyaan)
                ->orderBy('kode_opsi')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $opsiJawaban
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data opsi jawaban'
            ], 500);
        }
    }

    /**
     * Update opsi jawaban
     */
    public function update(Request $request, $idOpsi)
    {
        $request->validate([
            'isi_opsi' => 'required|string',
            'benar' => 'sometimes|boolean'
        ]);

        try {
            $opsi = OpsiJawaban::findOrFail($idOpsi);
            $opsi->update($request->only(['isi_opsi', 'benar']));

            return response()->json([
                'success' => true,
                'message' => 'Opsi jawaban berhasil diupdate'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate opsi jawaban'
            ], 500);
        }
    }

    /**
     * Hapus opsi jawaban
     */
    public function destroy($idOpsi)
    {
        try {
            $opsi = OpsiJawaban::findOrFail($idOpsi);
            $opsi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Opsi jawaban berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus opsi jawaban'
            ], 500);
        }
    }

    /**
     * Update kunci jawaban
     */
    public function updateKunciJawaban(Request $request)
    {
        $request->validate([
            'id_pertanyaan' => 'required|exists:pertanyaan,id_pertanyaan',
            'kunci_jawaban' => 'required|in:A,B,C,D,E'
        ]);

        try {
            DB::beginTransaction();

            // Reset semua opsi menjadi salah
            OpsiJawaban::where('id_pertanyaan', $request->id_pertanyaan)
                ->update(['benar' => 0]);

            // Set opsi yang dipilih sebagai benar
            OpsiJawaban::where('id_pertanyaan', $request->id_pertanyaan)
                ->where('kode_opsi', $request->kunci_jawaban)
                ->update(['benar' => 1]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Kunci jawaban berhasil diupdate'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kunci jawaban'
            ], 500);
        }
    }
}