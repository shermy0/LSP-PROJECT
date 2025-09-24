<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_dokumen')->insert([
            [
                'nama_jenis' => 'Fotokopi Rapor semester 1 s/d 5',
                'keterangan' => 'Lampiran rapor semester 1 sampai 5',
            ],
            [
                'nama_jenis' => 'Fotokopi Sertifikat PKL',
                'keterangan' => 'Lampiran sertifikat praktik kerja lapangan',
            ],
            [
                'nama_jenis' => 'Fotokopi Kartu Siswa',
                'keterangan' => 'Lampiran kartu tanda siswa',
            ],
            [
                'nama_jenis' => 'Fotokopi Kartu Keluarga/KTP',
                'keterangan' => 'Lampiran kartu keluarga atau KTP',
            ],
            [
                'nama_jenis' => 'Pas Foto 3x4',
                'keterangan' => 'Lampiran pas foto ukuran 3x4',
            ],
        ]);
    }
}
