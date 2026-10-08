<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('jenis_dokumen')->insert([
            // === A. Bukti Persyaratan Dasar Pemohon ===
            [
                'nama_dokumen' => 'Fotokopi Rapor Semester 1 s/d 5',
                'keterangan'   => 'Lampiran rapor semester 1 sampai 5 (format PDF atau JPG)',
                'kategori'     => 'dasar',
                'wajib'        => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_dokumen' => 'Fotokopi Sertifikat PKL',
                'keterangan'   => 'Lampiran sertifikat praktik kerja lapangan yang telah disahkan sekolah',
                'kategori'     => 'dasar',
                'wajib'        => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            // === B. Bukti Administratif ===
            [
                'nama_dokumen' => 'Fotokopi Kartu Siswa',
                'keterangan'   => 'Lampiran kartu tanda siswa aktif atau identitas pelajar',
                'kategori'     => 'administratif',
                'wajib'        => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_dokumen' => 'Fotokopi Kartu Keluarga / KTP',
                'keterangan'   => 'Lampiran kartu keluarga atau kartu tanda penduduk sebagai identitas',
                'kategori'     => 'administratif',
                'wajib'        => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_dokumen' => 'Pas Foto 3x4 Berwarna',
                'keterangan'   => 'Pas foto terbaru ukuran 3x4 dengan latar belakang merah atau biru',
                'kategori'     => 'administratif',
                'wajib'        => true,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
