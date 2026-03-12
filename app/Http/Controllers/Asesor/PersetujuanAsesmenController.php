<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanAsesmenController extends Controller
{
    /**
     * Menampilkan halaman form persetujuan asesmen (FR.AK.01)
     */
    public function form1()
    {
        // Data dummy untuk ditampilkan di form (nanti bisa diganti dengan data dari database)
        $data = [
            'skema' => (object) [
                'nama_skema' => 'JUNIOR OPERATOR DESAIN GRAFIS',
                'judul_skema' => 'JUNIOR OPERATOR DESAIN GRAFIS',
                'kode_skema' => 'J.59MTM00.001.1',
            ],
            'asesi' => (object) [
                'nama_lengkap' => Auth::user()->name ?? 'Nama Asesi',
            ],
            'tuk' => (object) [
                'nama_tuk' => 'TUK SMK Negeri 1 Bandung',
            ],
        ];

        return view('asesor.persetujuan_asesmen.form1', $data);
    }

    /**
     * Menyimpan data persetujuan asesmen (belum ada logic database)
     */
    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'tuk' => 'required',
            'metode' => 'required|array',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat_tuk' => 'required',
            'tgl_ttd_asesor' => 'required|date',
            'tgl_ttd_asesi' => 'required|date',
            'ttd_asesor' => 'required',
            'ttd_asesi' => 'required',
        ]);

        // Nantinya di sini akan ada logika penyimpanan ke database
        // Contoh: PersetujuanAsesmen::create([...]);

        // Redirect kembali ke halaman form dengan pesan sukses
        return redirect()->route('asesor.persetujuan_asesmen.form1')
            ->with('success', 'Data persetujuan asesmen berhasil disimpan.');
    }
}