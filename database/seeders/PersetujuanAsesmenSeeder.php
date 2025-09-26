<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // isi asesi
        DB::table('asesi')->insert([
            'id_asesi' => 1,
            'nama' => 'Reno Susanto',
            'alamat' => 'Bandung',
            'no_hp' => '08123456789',
        ]);

        // isi asesor
        DB::table('asesor')->insert([
            'id_asesor' => 1,
            'nama' => 'Martendi',
            'no_registrasi' => 'ASR-001',
        ]);

        // isi skema
        DB::table('skema_sertifikasi')->insert([
            'id_skema' => 1,
            'nama_skema' => 'Pemrograman Junior',
            'okupasi' => 'Software Developer',
        ]);

        // isi TUK
        DB::table('tuk')->insert([
            'id_tuk' => 1,
            'nama_tuk' => 'TUK SMKN 11 Bandung',
            'alamat' => 'Jl. Pajajaran Bandung',
        ]);

        // isi permohonan
        DB::table('permohonan')->insert([
            'id_permohonan' => 1,
            'id_asesi' => 1,
            'id_skema' => 1,
            'tanggal' => '2025-09-10',
            'status' => 'disetujui',
        ]);
    }
}
