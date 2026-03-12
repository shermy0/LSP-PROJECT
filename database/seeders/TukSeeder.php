<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tuk')->insert([
            [
                'id_tuk' => 1,
                'nama_tuk' => 'SMK Negri 11 Bandung',
                'jenis_tuk' => 'Mandiri',
                'alamat_tuk' => 'Jl. Raya Cilember, RT.01/RW.04, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40153',
                'status_tuk' => 'Aktif'
            ]
        ]);
    }
}