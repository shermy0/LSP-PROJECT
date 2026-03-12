<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkemaSertifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('skema_sertifikasi')->insert([
            [
                'id_skema' => 1,
                'nama_skema' => 'Junior Operator Desain Grafis',
                'judul_skema' => 'Operator Desain Grafis Tingkat Junior',
                'kode_skema' => 'SKM/BNSP/00010/2/2023/1226',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'DESAIN KOMUNIKASI VISUAL',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Junior Operator Desain Grafis',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 2,
                'nama_skema' => 'Junior Technical Support',
                'judul_skema' => 'Teknisi Junior Technical Support',
                'kode_skema' => 'SKM/BNSP/00010/2/2023/717',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Junior Technical Support.',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 3,
                'nama_skema' => 'Pemrogram Junior (Junior Coder)',
                'judul_skema' => 'Programmer Pemula (Junior Coder)',
                'kode_skema' => 'SKM/BNSP/00010/2/2023/1324',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Pemrogram Junior (Junior Coder).',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 4,
                'nama_skema' => 'Office Administrative',
                'judul_skema' => 'Administrasi Perkantoran Dasar',
                'kode_skema' => 'SKM/BNSP/00014/2/2023/845',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'deskripsi' => 'Skema Sertifikasi Okupasi Office Administrative',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 5,
                'nama_skema' => 'Pramuniaga',
                'judul_skema' => 'Pramuniaga / Sales Retail Dasar',
                'kode_skema' => 'SKM/BNSP/00007/2/2023/769',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'BISNIS DARING DAN PEMASARAN',
                'deskripsi' => 'Skema Sertifikasi Okupasi Pramuniaga',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 6,
                'nama_skema' => 'Akuntansi dan Keuangan Lembaga 1',
                'judul_skema' => 'Akuntansi Lembaga (Bagian 1)',
                'kode_skema' => 'SKM/BNSP/00013/1/2020/32',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 1 Akuntansi dan Keuangan Lembaga 1',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 7,
                'nama_skema' => 'Akuntansi dan Keuangan Lembaga 2',
                'judul_skema' => 'Akuntansi Lembaga (Bagian 2)',
                'kode_skema' => 'SKM/BNSP/00013/1/2020/32',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 2 Akuntansi dan Keuangan Lembaga 2',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 8,
                'nama_skema' => 'Teknik Komputer dan Jaringan 2',
                'judul_skema' => 'TKJ Tingkat 2',
                'kode_skema' => 'SKM/BNSP/00010/1/2020/38',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 1 Teknik Komputer dan Jaringan 2',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 9,
                'nama_skema' => 'Teknik Komputer dan Jaringan 3',
                'judul_skema' => 'TKJ Tingkat 3',
                'kode_skema' => 'SKM/BNSP/00010/1/2020/38',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 2 Teknik Komputer dan Jaringan 3',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 10,
                'nama_skema' => 'Teknik Komputer dan Jaringan 4',
                'judul_skema' => 'TKJ Tingkat 4',
                'kode_skema' => 'SKM/BNSP/00010/1/2020/38',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 3 Teknik Komputer dan Jaringan 4',
                'status_skema' => 'Aktif'
            ]
        ]);
    }
}