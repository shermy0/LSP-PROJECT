<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JurusanSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel jurusan.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode_jurusan' => 'DKV-01',
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'deskripsi' => 'Program studi desain komunikasi visual untuk media cetak dan digital',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_jurusan' => 'RPL-01',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Program studi pengembangan perangkat lunak dan aplikasi',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_jurusan' => 'TKJ-01',
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'deskripsi' => 'Program studi jaringan komputer dan administrasi sistem',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_jurusan' => 'MM-01',
                'nama_jurusan' => 'Multimedia',
                'deskripsi' => 'Program studi produksi konten multimedia interaktif',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kode_jurusan' => 'AK-01',
                'nama_jurusan' => 'Akuntansi',
                'deskripsi' => 'Program studi akuntansi dan keuangan',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}