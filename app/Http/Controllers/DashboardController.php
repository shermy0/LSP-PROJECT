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
                ['name' => 'Dashboard', 'route' => route('dashboard.admin'), 'icon' => 'fas fa-home'],
                ['name' => 'Data Peserta Uji', 'route' => '#', 'icon' => 'fas fa-users'],
            ];
        } elseif ($user->role == 'asesor') {
            $menus = [
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-file-alt'],
            ];
        } elseif ($user->role == 'asesi') {
            $menus = [
                ['name' => 'Dashboard', 'route' => route('asesi.dashboard'), 'icon' => 'fas fa-home'],
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-edit'],
            ];
        }

        return view('dashboard', compact('menus'));
    }

    public function admin()
    {
        // TODO: Nanti ganti dummy data ini dengan data asli dari DB
        $totalAsesi  = DB::table('asesi')->count();
        $totalAsesor = DB::table('asesor')->count();
        $totalAdmin  = DB::table('admin')->count();

        return view('admin.dashboard', compact('totalAsesi', 'totalAsesor', 'totalAdmin'));
    }

    public function asesi()
    {
        return view('asesi.dashboard');
    }

    public function asesor()
    {
        // Dummy data (sementara)
        $totalPeserta    = 284;
        $totalSertifikat = 284;
        $dalamProgres    = 284;
        $penghargaan     = 0;

        // Data chart (sementara)
        $labels = collect(['AKL', 'MPLB', 'PEMASARAN', 'M-LOG', 'DKV', 'RPL', 'TJKT']);
        $values = collect([45, 65, 30, 15, 40, 50, 10]);

        // Warna untuk chart
        $colors = ["#f1c40f", "#3498db", "#e74c3c", "#e67e22", "#9b59b6", "#2ecc71", "#7f8c8d"];

        // Cari jurusan dengan nilai tertinggi
        $maxIndex   = $values->search($values->max());
        $topJurusan = $labels[$maxIndex];
        $topColor   = $colors[$maxIndex];

        // Tambahan dummy untuk status kompeten (sementara)
        $kompeten = 200;
        $belumKompeten = 84;

        return view('asesor.dashboard', compact(
            'totalPeserta',
            'totalSertifikat',
            'dalamProgres',
            'penghargaan',
            'labels',
            'values',
            'topJurusan',
            'topColor',
            'kompeten',
            'belumKompeten'
        ));
    }
}
