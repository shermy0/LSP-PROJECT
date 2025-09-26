<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tuk')->updateOrInsert(
            ['id_tuk' => 1],
            [
                'nama_tuk' => 'TUK SMKN 11 Bandung',
                'alamat' => 'Jl. Budhi No. 98 Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
