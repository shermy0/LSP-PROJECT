<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;

class DataAsesorController extends Controller
{
    public function admin(Request $request)
{
    $query = Asesor::query();

    // 🔍 Pencarian nama atau NIP
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('nama_asesor', 'like', '%' . $request->search . '%')
              ->orWhere('nip', 'like', '%' . $request->search . '%');
        });
    }

    // 📌 Filter bidang keahlian
    if ($request->filled('bidang') && $request->bidang != 'Semua') {
        $query->where('bidang_keahlian', $request->bidang);
    }

    $asesor = $query->get();
    $total = Asesor::count();

    // ambil daftar bidang unik untuk dropdown
    $listBidang = Asesor::select('bidang_keahlian')->distinct()->pluck('bidang_keahlian');

    return view('admin.dataasesor', compact('asesor', 'total', 'listBidang'));
}

}
