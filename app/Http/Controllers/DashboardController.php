<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Redirect ke dashboard sesuai role (jika ada yang memanggil route 'dashboard')
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        Log::info('DashboardController@index dipanggil oleh user ID: ' . $user->id . ', role: ' . $user->role);

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'asesor':
                return redirect()->route('asesor.dashboard');
            case 'asesi':
                return redirect()->route('asesi.dashboard');
            default:
                return redirect()->route('login');
        }
    }

    /**
     * Dashboard Admin
     */
    public function admin()
    {
        if (!View::exists('admin.dashboard')) {
            Log::warning('View admin.dashboard tidak ditemukan');
            return redirect()->route('form_pra_assesmen');
        }

        $totalAsesi  = DB::table('asesi')->count();
        $totalAsesor = DB::table('asesor')->count();
        $totalAdmin  = DB::table('users')->where('role', 'admin')->count();

        return view('admin.dashboard', compact('totalAsesi', 'totalAsesor', 'totalAdmin'));
    }

    /**
     * Dashboard Asesi
     */
    public function asesi()
    {
        if (!View::exists('asesi.dashboard')) {
            Log::warning('View asesi.dashboard tidak ditemukan, redirect ke form_pra_assesmen');
            return redirect()->route('form_pra_assesmen');
        }
        return view('asesi.dashboard');
    }

    /**
     * Dashboard Asesor
     */
    public function asesor()
    {
        if (!View::exists('asesor.dashboard')) {
            Log::warning('View asesor.dashboard tidak ditemukan, redirect ke form_pra_assesmen');
            return redirect()->route('form_pra_assesmen');
        }

        // Data statistik jika diperlukan oleh view dashboard asesor
        $totalPeserta    = DB::table('asesi')->count();
        $totalSertifikat = DB::table('skema_sertifikasi')->count();
        $dalamProgres    = DB::table('permohonan')->where('status', 'Diajukan')->count();

        $labels = collect(['AKL', 'MPLB', 'PEMASARAN', 'M-LOG', 'DKV', 'RPL', 'TJKT']);
        $values = collect([45, 65, 30, 15, 40, 50, 10]);
        $colors = ["#f1c40f", "#3498db", "#e74c3c", "#e67e22", "#9b59b6", "#2ecc71", "#7f8c8d"];
        $maxIndex   = $values->search($values->max());
        $topJurusan = $labels[$maxIndex];
        $topColor   = $colors[$maxIndex];

        return view('asesor.dashboard', compact(
            'totalPeserta',
            'totalSertifikat',
            'dalamProgres',
            'labels',
            'values',
            'topJurusan',
            'topColor'
        ));
    }
}