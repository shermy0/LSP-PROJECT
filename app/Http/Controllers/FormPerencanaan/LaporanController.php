<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;  
use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Models\InstrumenAsesmen;
use Illuminate\Http\Request;
class LaporanController extends Controller
{
    public function showLaporan($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    return view('laporan', compact('skema'));
}
}