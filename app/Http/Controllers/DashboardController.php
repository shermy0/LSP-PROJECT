<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Menu otomatis berdasarkan role
        $menus = [];
        if ($user->role == 'admin') {
            $menus = [
                ['name' => 'Dashboard', 'route' => route('admin.dashboard'), 'icon' => 'fas fa-home'],
                ['name' => 'Data Peserta Uji', 'route' => '#', 'icon' => 'fas fa-users'],
            ];
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'asesor') {
            $menus = [
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-file-alt'],
            ];
            return redirect()->route('asesor.dashboard');
        } elseif ($user->role == 'asesi') {
            $menus = [
                ['name' => 'Dashboard', 'route' => route('asesi.dashboard'), 'icon' => 'fas fa-home'],
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-edit'],
                ['name' => 'Banding Asesmen', 'route' => route('banding.asesmen'), 'icon' => 'fas fa-exchange-alt'],
            ];
            return redirect()->route('asesi.dashboard');
        }

        // kalau role nggak cocok
        abort(403, 'Role tidak dikenal');
    }

    // =======================
    // DASHBOARD ADMIN
    // =======================
    public function admin()
    {
        $totalAsesi  = DB::table('asesi')->count();
        $totalAsesor = DB::table('asesor')->count();
        $totalAdmin  = DB::table('admin')->count();

        return view('dashboard.admin', compact('totalAsesi', 'totalAsesor', 'totalAdmin'));
    }

    // =======================
    // DASHBOARD ASESI
    // =======================
    public function asesi()
    {
        $user = auth()->user();

        // contoh data progress (kalau ada tabel progress)
        $totalUnit   = 10;
        $selesaiUnit = 8;

        $statusAsesmen     = "Proses Verifikasi"; 
        $statusSertifikasi = "Kompeten"; 
        $statusUjian       = "Sedang Ujian"; 

        return view('asesi.dashboard', compact(
            'user',
            'totalUnit',
            'selesaiUnit',
            'statusAsesmen',
            'statusSertifikasi',
            'statusUjian'
        ));
    }

    // =======================
    // DASHBOARD ASESOR
    // =======================
    public function asesor()
    {
        // contoh hitungan dari database
        $totalPeserta    = DB::table('asesi')->count();
        $totalSertifikat = DB::table('sertifikat')->count();
        $dalamProgres    = DB::table('asesi')->where('status', 'proses')->count();
        $penghargaan     = 10; // misal belum ada tabel, pakai dummy dulu

        // Data chart
        $labels = collect(['AKL', 'MPLB', 'PEMASARAN', 'M-LOG', 'DKV', 'RPL', 'TJKT']);
        $values = collect([45, 65, 30, 15, 40, 50, 10]);

        // Warna dasar sama dengan di chart.js
        $colors = ["#f1c40f","#3498db","#e74c3c","#e67e22","#9b59b6","#2ecc71","#7f8c8d"];

        $maxIndex   = $values->search($values->max());
        $topJurusan = $labels[$maxIndex];
        $topColor   = $colors[$maxIndex];

        return view('asesor.dashboard', compact(
            'totalPeserta',
            'totalSertifikat',
            'dalamProgres',
            'penghargaan',
            'labels',
            'values',
            'topJurusan',
            'topColor'
        ));
    }
}
