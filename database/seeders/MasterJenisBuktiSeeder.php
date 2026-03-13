<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJenisBuktiSeeder extends Seeder
{
    public function run()
    {
        $bukti = [
            ['nama_bukti' => 'verifikasi_portofolio'],
            ['nama_bukti' => 'observasi_langsung'],
            ['nama_bukti' => 'pertanyaan_lisan'],
            ['nama_bukti' => 'reviu_produk'],
            ['nama_bukti' => 'kegiatan_terstruktur'],
            ['nama_bukti' => 'pertanyaan_tertulis'],
            ['nama_bukti' => 'pertanyaan_wawancara'],
            ['nama_bukti' => 'lainnya'],
        ];

        DB::table('master_jenis_bukti')->insert($bukti);
    }
}