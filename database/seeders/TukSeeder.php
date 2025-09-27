<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TukSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tuk')->insert([
            [
                'id_tuk' => 1,
                'nama_tuk' => 'SMK Negri 11 Bandung',
                'jenis_tuk' => 'Mandiri',
                'alamat_tuk' => 'Jl. Raya Cilember, RT.01/RW.04, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40153',
                'email' => 'smkn11bdg@gmail.com',
                'fax' => '022-6613508',
                'jabatan' => 'SMK Negeri 11 Bandung',
                'telepon' => '022-6652442',
                'status_tuk' => 'Aktif'
            ]
        ]);

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
