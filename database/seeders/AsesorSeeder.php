<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asesor')->insert([
            [
                'id_asesor' => 1,
                'user_id' => 4,
                'nama_asesor' => 'Martendi Mondiyana',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0081412017',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:28:39'
            ],
            [
                'id_asesor' => 2,
                'user_id' => 5,
                'nama_asesor' => 'Usep Nurjaman',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0095262018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:34'
            ],
            [
                'id_asesor' => 3,
                'user_id' => 6,
                'nama_asesor' => 'Ade Sarkosih',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0095272018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:42'
            ],
            [
                'id_asesor' => 4,
                'user_id' => 7,
                'nama_asesor' => 'Santi Yulianasari',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0140692019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:55'
            ],
            [
                'id_asesor' => 5,
                'user_id' => 8,
                'nama_asesor' => 'Elies Diaty',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0140702019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:01'
            ],
            [
                'id_asesor' => 6,
                'user_id' => 9,
                'nama_asesor' => 'Parwanto',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'BISNIS DARING DAN PEMASARAN',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0095372018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:06'
            ],
            [
                'id_asesor' => 7,
                'user_id' => 10,
                'nama_asesor' => 'Hj. Rodiyah',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'BISNIS DARING DAN PEMASARAN',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0140842019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:17'
            ],
            [
                'id_asesor' => 8,
                'user_id' => 11,
                'nama_asesor' => 'Ratna Suminar',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'BISNIS DARING DAN PEMASARAN',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0140852019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:22'
            ],
            [
                'id_asesor' => 9,
                'user_id' => 12,
                'nama_asesor' => 'Zimzim Al Amin Syahid',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'DESAIN KOMUNIKASI VISUAL',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0117302016',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:31'
            ],
            [
                'id_asesor' => 10,
                'user_id' => 13,
                'nama_asesor' => 'Ade suryadi',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'DESAIN KOMUNIKASI VISUAL',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0013592019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:37'
            ],
            [
                'id_asesor' => 11,
                'user_id' => 14,
                'nama_asesor' => 'Sutarsa',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'DESAIN KOMUNIKASI VISUAL',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0013582019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:43'
            ],
            [
                'id_asesor' => 12,
                'user_id' => 15,
                'nama_asesor' => 'Lilis Nurlela',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0140652019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:55'
            ],
            [
                'id_asesor' => 13,
                'user_id' => 16,
                'nama_asesor' => 'Risna Maelani',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0060902016',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:06'
            ],
            [
                'id_asesor' => 14,
                'user_id' => 17,
                'nama_asesor' => 'Tatang Tahyan',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0095352018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:11'
            ],
            [
                'id_asesor' => 15,
                'user_id' => 18,
                'nama_asesor' => 'Yudi Subekti',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0022762013',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:17'
            ],
            [
                'id_asesor' => 16,
                'user_id' => 19,
                'nama_asesor' => 'Himatul Munawaroh',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0022802013',
                'createdat' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:21'
            ],
            [
                'id_asesor' => 17,
                'user_id' => 20,
                'nama_asesor' => 'Ani Nuraeni',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0145302019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:28'
            ],
            [
                'id_asesor' => 18,
                'user_id' => 21,
                'nama_asesor' => 'Dedi Suryadi',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0051362021',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:32'
            ],
            [
                'id_asesor' => 19,
                'user_id' => 22,
                'nama_asesor' => 'Regina Agustini',
                'nip' => null,
                'email' => null,
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'jabatan' => null,
                'no_registrasi' => 'MET.000.0051342021',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:38'
            ]
        ]);
    }
}