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
                ['name' => 'Dashboard', 'route' => route('dashboard.asesi'), 'icon' => 'fas fa-home'],
                ['name' => 'Form Perencanaan', 'route' => route('formperencanaan'), 'icon' => 'fas fa-edit'],
            ];
        }

        return view('dashboard', compact('menus'));
    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function asesi()
    {
        $user = auth()->user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        return view('asesi.dashboard', compact('user', 'asesi'));
    }

    public function asesor()
    {
        $user = auth()->user();
        $asesi = DB::table('asesi')->where('user_id', $user->id)->first();

        $totalPeserta = 284;
        $totalSertifikat = 284;
        $dalamProgres = 284;
        $penghargaan = 284;

        // Data chart
        $labels = collect(['AKL', 'MPLB', 'PEMASARAN', 'M-LOG', 'DKV', 'RPL', 'TJKT']);
        $values = collect([45, 65, 30, 15, 40, 50, 10]);

        $colors = ["#f1c40f", "#3498db", "#e74c3c", "#e67e22", "#9b59b6", "#2ecc71", "#7f8c8d"];

        $maxIndex = $values->search($values->max());
        $topJurusan = $labels[$maxIndex];
        $topColor = $colors[$maxIndex];

        return view('asesor.dashboard', compact(
            'user',
            'asesi',
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
