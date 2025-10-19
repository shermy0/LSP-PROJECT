<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkemaSertifikasiSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel skema_sertifikasi.
     */
    public function run(): void
    {
        DB::table('skema_sertifikasi')->insert([
            [
                'kode_skema'       => 'SKM-DKV-01',
                'nama_skema'       => 'Junior Operator Desain Grafis',
                'jenjang'          => 'Okupasi',
                'bidang_keahlian'  => 'Desain Komunikasi Visual',
                'deskripsi'        => 'Skema sertifikasi untuk okupasi Junior Operator Desain Grafis.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-TKJ-01',
                'nama_skema'       => 'Junior Technical Support',
                'jenjang'          => 'Okupasi',
                'bidang_keahlian'  => 'Teknik Komputer dan Jaringan',
                'deskripsi'        => 'Skema sertifikasi untuk okupasi Junior Technical Support.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-RPL-01',
                'nama_skema'       => 'Pemrogram Junior (Junior Coder)',
                'jenjang'          => 'Okupasi',
                'bidang_keahlian'  => 'Pengembangan Perangkat Lunak dan Gim',
                'deskripsi'        => 'Skema sertifikasi untuk okupasi Pemrogram Junior (Junior Coder).',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-MP-01',
                'nama_skema'       => 'Office Administrative',
                'jenjang'          => 'Okupasi',
                'bidang_keahlian'  => 'Manajemen Perkantoran dan Layanan Bisnis',
                'deskripsi'        => 'Skema sertifikasi okupasi Office Administrative.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-BR-01',
                'nama_skema'       => 'Pramuniaga',
                'jenjang'          => 'Okupasi',
                'bidang_keahlian'  => 'Bisnis Daring dan Pemasaran',
                'deskripsi'        => 'Skema sertifikasi okupasi Pramuniaga.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-AKL-01',
                'nama_skema'       => 'Akuntansi dan Keuangan Lembaga 1',
                'jenjang'          => 'KKNI Level II',
                'bidang_keahlian'  => 'Akuntansi dan Keuangan Lembaga',
                'deskripsi'        => 'Skema sertifikasi kelompok pekerjaan 1 Akuntansi dan Keuangan Lembaga 1.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-AKL-02',
                'nama_skema'       => 'Akuntansi dan Keuangan Lembaga 2',
                'jenjang'          => 'KKNI Level II',
                'bidang_keahlian'  => 'Akuntansi dan Keuangan Lembaga',
                'deskripsi'        => 'Skema sertifikasi kelompok pekerjaan 2 Akuntansi dan Keuangan Lembaga 2.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-TKJ-02',
                'nama_skema'       => 'Teknik Komputer dan Jaringan 2',
                'jenjang'          => 'KKNI Level II',
                'bidang_keahlian'  => 'Teknik Komputer dan Jaringan',
                'deskripsi'        => 'Skema sertifikasi kelompok pekerjaan 1 Teknik Komputer dan Jaringan 2.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-TKJ-03',
                'nama_skema'       => 'Teknik Komputer dan Jaringan 3',
                'jenjang'          => 'KKNI Level II',
                'bidang_keahlian'  => 'Teknik Komputer dan Jaringan',
                'deskripsi'        => 'Skema sertifikasi kelompok pekerjaan 2 Teknik Komputer dan Jaringan 3.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'kode_skema'       => 'SKM-TKJ-04',
                'nama_skema'       => 'Teknik Komputer dan Jaringan 4',
                'jenjang'          => 'KKNI Level II',
                'bidang_keahlian'  => 'Teknik Komputer dan Jaringan',
                'deskripsi'        => 'Skema sertifikasi kelompok pekerjaan 3 Teknik Komputer dan Jaringan 4.',
                'status_skema'     => 'Aktif',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
        ]);
    }
}
