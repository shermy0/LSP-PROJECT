<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\{JawabanDemonstrasi, Asesi};

class JawabanDemonstrasiController extends Controller
{
    public function show($id_skema)
    {
        $user = auth()->user();
        $asesi = Asesi::where('user_id', $user->id)->firstOrFail();

        // Struktur tabel demonstrasi berbeda pada beberapa database yang sudah
        // berjalan. Daftar tugas sendiri terhubung ke skema, jadi jangan
        // mensyaratkan baris demonstrasi dengan kolom id_skema.
        $taskQuery = DB::table('master_tugas_demonstrasi')
            ->where('id_skema', $id_skema)
            ->orderBy('id_tugas');

        $tugas = $taskQuery->get()->map(function ($task) {
            $task->isi_pertanyaan_demonstrasi = $task->isi_pertanyaan_demonstrasi
                ?? $task->nama_tugas
                ?? $task->deskripsi_pertanyaan
                ?? 'Tugas demonstrasi';
            $task->deskripsi_pertanyaan = $task->deskripsi_pertanyaan ?? $task->instruksi ?? null;
            $task->file_path = $task->file_path ?? null;
            return $task;
        });

        $jawabanSebelumnya = collect();
        if (Schema::hasTable('jawaban_demonstrasi')
            && Schema::hasColumn('jawaban_demonstrasi', 'id_asesi')
            && Schema::hasColumn('jawaban_demonstrasi', 'id_tugas')) {
            $jawabanQuery = DB::table('jawaban_demonstrasi')
                ->where('id_asesi', $asesi->id_asesi)
                ->whereIn('id_tugas', $tugas->pluck('id_tugas'));

            $jawabanSebelumnya = $jawabanQuery->get()->keyBy('id_tugas');
        }

        $demoId = Schema::hasTable('demonstrasi')
            && Schema::hasColumn('demonstrasi', 'id_skema')
                ? DB::table('demonstrasi')->where('id_skema', $id_skema)->value('id_demonstrasi')
                : null;

        return view('demonstrasi.jawab', [
            'id_skema' => $id_skema,
            'id_demonstrasi' => $demoId,
            'tugas' => $tugas,
            'timer' => 0,
            'asesi' => $asesi,
            'jawabanSebelumnya' => $jawabanSebelumnya,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_skema' => 'required',
            'id_demonstrasi' => 'required',
            'jawaban_text' => 'array',
            'jawaban_file.*' => 'nullable|file|max:5120'
        ]);

        $user = auth()->user();
        $asesi = Asesi::where('user_id', $user->id)->firstOrFail();

        foreach ($request->jawaban_text as $id_tugas => $jawaban) {
            $filePath = null;
            if ($request->hasFile("jawaban_file.$id_tugas")) {
                $file = $request->file("jawaban_file.$id_tugas");
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('jawaban_demonstrasi', $fileName, 'public');
            }

            JawabanDemonstrasi::updateOrCreate(
                [
                    'id_tugas' => $id_tugas,
                    'id_asesi' => $asesi->id_asesi,
                    'id_skema' => $request->id_skema
                ],
                [
                    'jawaban_text' => $jawaban,
                    'jawaban_file' => $filePath
                ]
            );
        }

        // Simpan tanda tangan jika ada
        if ($request->filled('ttd_asesi')) {
            $ttdData = preg_replace('#^data:image/\w+;base64,#i', '', $request->ttd_asesi);
            $ttdData = str_replace(' ', '+', $ttdData);
            $imageData = base64_decode($ttdData);

            $namaAsesi = Str::slug($asesi->nama_lengkap, '_');
            $tanggal = $request->tgl_ttd_asesi ?: date('Y-m-d');
            $fileName = 'ttd_asesmen_demonstrasi_'.$namaAsesi . '_' . '_'. $tanggal . '.png';
            $filePath = storage_path('app/public/ttd/' . $fileName);

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            file_put_contents($filePath, $imageData);

            $lastJawaban = JawabanDemonstrasi::where('id_asesi', $asesi->id_asesi)
                ->where('id_skema', $request->id_skema)
                ->orderBy('id_jawaban', 'desc')
                ->first();

            if ($lastJawaban) {
                DB::table('jawaban_demonstrasi_persetujuan')->updateOrInsert(
                    ['id_jawaban' => $lastJawaban->id_jawaban],
                    [
                        'tgl_ttd_asesi' => $tanggal,
                        'ttd_asesi' => 'storage/ttd/' . $fileName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }


        return redirect()->route('asesi.dashboard')->with('success', 'Jawaban demonstrasi berhasil disimpan!');
    }
}
