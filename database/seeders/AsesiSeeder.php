<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asesi')->insert([
            [
                'id_asesi' => 1,
                'user_id' => 3,
                'asesor_id' => null,
                'nik' => '9674567436743289',
                'nama_lengkap' => 'Reno Susanto',
                'tempat_lahir' => 'Bandung',
                'tgl_lahir' => '2025-09-05',
                'jenis_kelamin' => 'L',
                'kebangsaan' => null,
                'alamat' => null,
                'telepon' => '09887645567546',
                'email' => null,
                'pendidikan_terakhir' => null,
                'institusi' => null,
                'jabatan' => null,
                'alamat_kantor' => null,
                'telepon_kantor' => null,
                'created_at' => '2025-09-03 19:01:25',
                'updated_at' => '2025-09-03 19:01:25'
            ]
        ]);
    }
}