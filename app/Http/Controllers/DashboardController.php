<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class DashboardController extends Controller
{
    public function ninjau_asesemen()
    {
        // Ambil salah satu data skema (contoh id=1)
        $skema = Skema::first(); 
        
        // Kirim ke view
        return view('ninjau_asesemen', compact('skema'));
    }
}