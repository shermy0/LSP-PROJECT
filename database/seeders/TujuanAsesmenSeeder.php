<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TujuanAsesmenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tujuan_asesmen')->insert([
            ['nama_tujuan' => 'Sertifikasi'],
            ['nama_tujuan' => 'Pengakuan Kompetensi Terkini (PKT)'],
            ['nama_tujuan' => 'Rekognisi Pembelajaran Lampau (RPL)'],
        ]);
    }
}
