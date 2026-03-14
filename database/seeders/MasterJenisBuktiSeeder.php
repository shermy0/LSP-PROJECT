<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJenisBuktiSeeder extends Seeder
{
    public function run()
    {
        $bukti = [
            ['nama_bukti' => 'Hasil Verifikasi Portofolio'],
            ['nama_bukti' => 'Hasil Observasi Langsung'],
            ['nama_bukti' => 'Hasil Pertanyaan Lisan'],
            ['nama_bukti' => 'Hasil Reviu Produk'],
            ['nama_bukti' => 'Hasil Kegiatan Terstruktur'],
            ['nama_bukti' => 'Hasil Pertanyaan Tertulis'],
            ['nama_bukti' => 'Hasil Pertanyaan Wawancara'],
            ['nama_bukti' => 'Lainnya'],
        ];

        DB::table('master_jenis_bukti')->insert($bukti);
    }
}