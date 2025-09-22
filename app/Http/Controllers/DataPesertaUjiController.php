<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;

class DataPesertaUjiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::query();

        // Filter Search Nama
        if ($request->filled('search')) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter Status
        if ($request->filled('status')) {
            if ($request->status === 'lengkap') {
                $query->where('status', 'Lengkap');
            } elseif ($request->status === 'belum') {
                $query->where('status', 'Belum Lengkap');
            }
        }

        // Ambil data peserta (pagination)
        $peserta = $query->paginate(10)->withQueryString();

        // Hitung total peserta
        $totalPeserta = Peserta::count();
        $pesertaLengkap = Peserta::where('status', 'Lengkap')->count();
        $pesertaBelumLengkap = Peserta::where('status', 'Belum Lengkap')->count();

        // Ambil daftar kelas unik dari tabel untuk dropdown
        $kelasList = Peserta::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas') ?? collect([]);

        return view('datapesertauji', compact(
            'peserta',
            'totalPeserta',
            'pesertaLengkap',
            'pesertaBelumLengkap',
            'kelasList'
        ));
    }

    public function show($id)
    {
        $peserta = Peserta::findOrFail($id);
        return view('detailpesertauji', compact('peserta'));
    }
}
