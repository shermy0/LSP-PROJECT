<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'pertanyaan_') === 0) {
                $index = explode('_', $key)[1];

                // Simpan data untuk tiap pertanyaan
                $pertanyaan = new Pertanyaan();
                $pertanyaan->pertanyaan = $request->input("pertanyaan_$index");

                // Ambil opsi jawaban
                $opsi = [];
                foreach (['A','B','C','D','E'] as $opt) {
                    $opsi[$opt] = $request->input("jawaban_{$index}_{$opt}");
                }
                $pertanyaan->opsi_jawaban = json_encode($opsi);

                // Simpan kunci jawaban
                $pertanyaan->kunci_jawaban = $request->input("kunci_$index");

                // Upload gambar (jika ada)
                if ($request->hasFile("gambar_$index")) {
                    $gambar = $request->file("gambar_$index")->store('pertanyaan/gambar', 'public');
                    $pertanyaan->gambar = $gambar;
                }

                // Upload file pendukung (jika ada)
                if ($request->hasFile("file_$index")) {
                    $filePendukung = $request->file("file_$index")->store('pertanyaan/file', 'public');
                    $pertanyaan->file_pendukung = $filePendukung;
                }

                $pertanyaan->save();
            }
        }

        return redirect()->back()->with('success', 'Pertanyaan berhasil disimpan!');
    }
}
