<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesorSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID jurusan yang sudah ada di database
        $jurusanIds = [
            'AKUNTANSI DAN KEUANGAN LEMBAGA' => DB::table('jurusan')->where('nama_jurusan', 'AKUNTANSI DAN KEUANGAN LEMBAGA')->value('id_jurusan'),
            'BISNIS DARING DAN PEMASARAN' => DB::table('jurusan')->where('nama_jurusan', 'BISNIS DARING DAN PEMASARAN')->value('id_jurusan'),
            'DESAIN KOMUNIKASI VISUAL' => DB::table('jurusan')->where('nama_jurusan', 'DESAIN KOMUNIKASI VISUAL')->value('id_jurusan'),
            'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS' => DB::table('jurusan')->where('nama_jurusan', 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS')->value('id_jurusan'),
            'PENGEMBANGAN PERANGKAT LUNAK DAN GIM' => DB::table('jurusan')->where('nama_jurusan', 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM')->value('id_jurusan'),
            'TEKNIK KOMPUTER DAN JARINGAN' => DB::table('jurusan')->where('nama_jurusan', 'TEKNIK KOMPUTER DAN JARINGAN')->value('id_jurusan'),
        ];

        // Validasi semua jurusan ditemukan
        if (in_array(null, $jurusanIds, true)) {
            throw new \Exception('Jurusan tidak lengkap. Jalankan JurusanSeeder terlebih dahulu.');
        }

        $asesors = [
            [
                'user_id' => 4,
                'nama_asesor' => 'Martendi Mondiyana',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['AKUNTANSI DAN KEUANGAN LEMBAGA'],
                'no_registrasi' => 'MET.000.0081412017',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:28:39'
            ],
            [
                'user_id' => 5,
                'nama_asesor' => 'Usep Nurjaman',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['AKUNTANSI DAN KEUANGAN LEMBAGA'],
                'no_registrasi' => 'MET.000.0095262018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:34'
            ],
            [
                'user_id' => 6,
                'nama_asesor' => 'Ade Sarkosih',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['AKUNTANSI DAN KEUANGAN LEMBAGA'],
                'no_registrasi' => 'MET.000.0095272018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:42'
            ],
            [
                'user_id' => 7,
                'nama_asesor' => 'Santi Yulianasari',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['AKUNTANSI DAN KEUANGAN LEMBAGA'],
                'no_registrasi' => 'MET.000.0140692019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:41:55'
            ],
            [
                'user_id' => 8,
                'nama_asesor' => 'Elies Diaty',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['AKUNTANSI DAN KEUANGAN LEMBAGA'],
                'no_registrasi' => 'MET.000.0140702019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:01'
            ],
            [
                'user_id' => 9,
                'nama_asesor' => 'Parwanto',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['BISNIS DARING DAN PEMASARAN'],
                'no_registrasi' => 'MET.000.0095372018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:06'
            ],
            [
                'user_id' => 10,
                'nama_asesor' => 'Hj. Rodiyah',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['BISNIS DARING DAN PEMASARAN'],
                'no_registrasi' => 'MET.000.0140842019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:17'
            ],
            [
                'user_id' => 11,
                'nama_asesor' => 'Ratna Suminar',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['BISNIS DARING DAN PEMASARAN'],
                'no_registrasi' => 'MET.000.0140852019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:22'
            ],
            [
                'user_id' => 12,
                'nama_asesor' => 'Zimzim Al Amin Syahid',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['DESAIN KOMUNIKASI VISUAL'],
                'no_registrasi' => 'MET.000.0117302016',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:31'
            ],
            [
                'user_id' => 13,
                'nama_asesor' => 'Ade suryadi',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['DESAIN KOMUNIKASI VISUAL'],
                'no_registrasi' => 'MET.000.0013592019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:37'
            ],
            [
                'user_id' => 14,
                'nama_asesor' => 'Sutarsa',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['DESAIN KOMUNIKASI VISUAL'],
                'no_registrasi' => 'MET.000.0013582019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:43'
            ],
            [
                'user_id' => 15,
                'nama_asesor' => 'Lilis Nurlela',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS'],
                'no_registrasi' => 'MET.000.0140652019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:42:55'
            ],
            [
                'user_id' => 16,
                'nama_asesor' => 'Risna Maelani',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS'],
                'no_registrasi' => 'MET.000.0060902016',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:06'
            ],
            [
                'user_id' => 17,
                'nama_asesor' => 'Tatang Tahyan',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS'],
                'no_registrasi' => 'MET.000.0095352018',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:11'
            ],
            [
                'user_id' => 18,
                'nama_asesor' => 'Yudi Subekti',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['PENGEMBANGAN PERANGKAT LUNAK DAN GIM'],
                'no_registrasi' => 'MET.000.0022762013',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:17'
            ],
            [
                'user_id' => 19,
                'nama_asesor' => 'Himatul Munawaroh',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['PENGEMBANGAN PERANGKAT LUNAK DAN GIM'],
                'no_registrasi' => 'MET.000.0022802013',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:21'
            ],
            [
                'user_id' => 20,
                'nama_asesor' => 'Ani Nuraeni',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['PENGEMBANGAN PERANGKAT LUNAK DAN GIM'],
                'no_registrasi' => 'MET.000.0145302019',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:28'
            ],
            [
                'user_id' => 21,
                'nama_asesor' => 'Dedi Suryadi',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['TEKNIK KOMPUTER DAN JARINGAN'],
                'no_registrasi' => 'MET.000.0051362021',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:32'
            ],
            [
                'user_id' => 22,
                'nama_asesor' => 'Regina Agustini',
                'nip' => null,
                'email' => null,
                'telepon' => null,
                'jabatan' => null,
                'id_jurusan' => $jurusanIds['TEKNIK KOMPUTER DAN JARINGAN'],
                'no_registrasi' => 'MET.000.0051342021',
                'created_at' => '2025-09-04 04:24:34',
                'updated_at' => '2025-09-04 04:43:38'
            ]
        ];

        foreach ($asesors as $asesor) {
            DB::table('asesor')->updateOrInsert(
                ['user_id' => $asesor['user_id']],
                $asesor
            );
        }
    }
}