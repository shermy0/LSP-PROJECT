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
        // Pastikan view ada, jika tidak redirect ke halaman default
        if (!View::exists('admin.dashboard')) {
            Log::warning('View admin.dashboard tidak ditemukan');
            return redirect()->route('form_pra_assesmen');
        }
        return view('admin.dashboard');
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

        // --- REAL DATA ---
        $totalPeserta    = DB::table('asesi')->count();
        $totalSertifikat = DB::table('sertifikat')->count();
        $dalamProgres    = DB::table('asesmen')->where('status', 'proses')->count();

        $kompeten        = DB::table('hasil_asesmen')->where('status', 'kompeten')->count();
        $belumKompeten   = DB::table('hasil_asesmen')->where('status', 'belum kompeten')->count();

        // --- DUMMY DATA (sementara) ---
        $penghargaan     = 0;

        // Grafik sertifikasi per jurusan (dummy)
        $labels = collect(['AKL', 'MPLB', 'PEMASARAN', 'M-LOG', 'DKV', 'RPL', 'TJKT']);
        $values = collect([45, 65, 30, 15, 40, 50, 10]);

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
            'topColor',
            'kompeten',
            'belumKompeten'
        ));
    }
}