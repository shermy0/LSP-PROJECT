<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesorSkemaSeeder extends Seeder
{
    public function run(): void
    {
        $asesors = DB::table('asesor')->get();

        $skemaMapping = [
            'AKUNTANSI DAN KEUANGAN LEMBAGA' => [6, 7],
            'BISNIS DARING DAN PEMASARAN' => [5],
            'DESAIN KOMUNIKASI VISUAL' => [1],
            'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS' => [4],
            'PENGEMBANGAN PERANGKAT LUNAK DAN GIM' => [3],
            'TEKNIK KOMPUTER DAN JARINGAN' => [2, 8, 9, 10],
        ];

        foreach ($asesors as $asesor) {
            $jurusan = DB::table('jurusan')->where('id_jurusan', $asesor->id_jurusan)->first();
            if (!$jurusan) continue;

            $skemaIds = $skemaMapping[$jurusan->nama_jurusan] ?? [];

            foreach ($skemaIds as $idSkema) {
                DB::table('asesor_skema')->updateOrInsert(
                    [
                        'id_asesor' => $asesor->id_asesor,
                        'id_skema' => $idSkema
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}