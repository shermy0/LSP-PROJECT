<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelompok_pekerjaan')->insert([
            [
                'id_skema' => 2,
                'nama_kelompok' => 'Kelompok Pekerjaan 1',
            ],
            [
                'id_skema' => 2,
                'nama_kelompok' => 'Kelompok Pekerjaan 2',
            ],
            [
                'id_skema' => 2,
                'nama_kelompok' => 'Kelompok Pekerjaan 3',
            ],
        ]);
    }
}
