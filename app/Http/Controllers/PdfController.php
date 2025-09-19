<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    // ✅ FRIA05B
    public function unduhFria05b(Request $request)
    {
        $jawaban = json_decode($request->jawaban, true) ?? [];
        $penyusun = json_decode($request->penyusun, true) ?? [];

        $data = [
            'no_form'      => $request->no_form ?? '-',
            'judul_skema'  => $request->judul_skema ?? '-',
            'tuk'          => $request->tuk ?? '-',
            'jawaban'      => $jawaban,
            'penyusun'     => $penyusun,
        ];

        $pdf = PDF::loadView('laporan1', $data);
        return $pdf->download('FRIA05B_Kunci_Jawaban.pdf');
    }

    // ✅ FRIA05C
    public function unduhFria05c(Request $request)
    {
        $jawaban = json_decode($request->jawaban, true) ?? [];

        $data = [
            'no_form'          => $request->no_form ?? '-',
            'judul_skema'      => $request->judul_skema ?? '-',
            'nama_asesor'      => $request->nama_asesor ?? '-',
            'nama_asesi'       => $request->nama_asesi ?? '-',
            'tanggal_asesmen'  => $request->tanggal_asesmen ?? '-',
            'tuk'              => $request->tuk ?? '-',
            'jawaban'          => $jawaban,
            'umpan_balik'      => $request->umpan_balik ?? '',
            'ttdAsesi'         => $request->tanda_tangan_asesi ?? null,
            'ttdAsesor'        => $request->tanda_tangan_asesor ?? null,
        ];

        $pdf = PDF::loadView('laporan', $data);
        return $pdf->download('FRIA05C_Lembar_Jawaban.pdf');
    }
}
