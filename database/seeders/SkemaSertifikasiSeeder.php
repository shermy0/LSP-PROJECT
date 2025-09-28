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
                'kode_skema' => 'SKM-DKV-01',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'DESAIN KOMUNIKASI VISUAL',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Junior Operator Desain Grafis',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 2,
                'nama_skema' => 'Junior Technical Support',
                'kode_skema' => 'SKM-TKJ-01',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Junior Technical Support.',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 3,
                'nama_skema' => 'Pemrogram Junior (Junior Coder)',
                'kode_skema' => 'SKM-RPL-01',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
                'deskripsi' => 'Skema sertifikasi untuk okupasi Pemrogram Junior (Junior Coder).',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 4,
                'nama_skema' => 'Office Administrative',
                'kode_skema' => 'SKM-MP-01',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'MANAJEMEN PERKANTORAN DAN LAYANAN BISNIS',
                'deskripsi' => 'Skema Sertifikasi Okupasi Office Administrative',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 5,
                'nama_skema' => 'Pramuniaga',
                'kode_skema' => 'SKM-BR-01',
                'jenjang' => 'Okupasi',
                'bidang_keahlian' => 'BISNIS DARING DAN PEMASARAN',
                'deskripsi' => 'Skema Sertifikasi Okupasi Pramuniaga',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 6,
                'nama_skema' => 'Akuntansi dan Keuangan Lembaga 1',
                'kode_skema' => 'SKM-AKL-01',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 1 Akuntansi dan Keuangan Lembaga 1',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 7,
                'nama_skema' => 'Akuntansi dan Keuangan Lembaga 2',
                'kode_skema' => 'SKM-AKL-02',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'AKUNTANSI DAN KEUANGAN LEMBAGA',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 2 Akuntansi dan Keuangan Lembaga 2',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 8,
                'nama_skema' => 'Teknik Komputer dan Jaringan 2',
                'kode_skema' => 'SKM-TKJ-02',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 1 Teknik Komputer dan Jaringan 2',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 9,
                'nama_skema' => 'Teknik Komputer dan Jaringan 3',
                'kode_skema' => 'SKM-TKJ-03',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 2 Teknik Komputer dan Jaringan 3',
                'status_skema' => 'Aktif'
            ],
            [
                'id_skema' => 10,
                'nama_skema' => 'Teknik Komputer dan Jaringan 4',
                'kode_skema' => 'SKM-TKJ-04',
                'jenjang' => 'KKNI Level II',
                'bidang_keahlian' => 'TEKNIK KOMPUTER DAN JARINGAN',
                'deskripsi' => 'Skema Sertifikasi untuk kelompok pekerjaan 3 Teknik Komputer dan Jaringan 4',
                'status_skema' => 'Aktif'
            ]
        ]);
    }
}