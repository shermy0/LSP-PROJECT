<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = [
            [
                'kode_jurusan' => 'AKL',
                'nama_jurusan' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'deskripsi' => 'Program studi akuntansi dan keuangan lembaga',
                'status' => 'aktif',
            ],
            [
                'kode_jurusan' => 'BDP',
                'nama_jurusan' => 'BISNIS DARING DAN PEMASARAN',
                'deskripsi' => 'Program studi bisnis daring dan pemasaran',
                'status' => 'aktif',
            ],
            [
                'kode_jurusan' => 'DKV',
                'nama_jurusan' => 'DESAIN KOMUNIKASI VISUAL',
                'deskripsi' => 'Program studi desain komunikasi visual',
                'status' => 'aktif',
            ],
            [
                'kode_jurusan' => 'MPL',
                'nama_jurusan' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'deskripsi' => 'Program studi manajemen perkantoran dan layanan bisnis',
                'status' => 'aktif',
            ],
            [
                'kode_jurusan' => 'PPL',
                'nama_jurusan' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'deskripsi' => 'Program studi pengembangan perangkat lunak dan gim',
                'status' => 'aktif',
            ],
            [
                'kode_jurusan' => 'TKJ',
                'nama_jurusan' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Program studi teknik komputer dan jaringan',
                'status' => 'aktif',
            ],
        ];

        foreach ($jurusan as $data) {
            DB::table('jurusan')->updateOrInsert(
                ['nama_jurusan' => $data['nama_jurusan']],
                [
                    'kode_jurusan' => $data['kode_jurusan'],
                    'deskripsi' => $data['deskripsi'],
                    'status' => $data['status'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}