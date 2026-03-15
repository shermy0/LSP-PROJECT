<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsesiSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel asesi.
     */
    public function run(): void
    {
        DB::table('asesi')->insert([
            [
                'user_id'              => 3,
                'jurusan_id'           => 1, // Desain Komunikasi Visual
                'asesor_id'            => 6, // Ade Sarkosih
                'nik'                  => '9674567436743289',
                'nama_lengkap'         => 'Reno Susanto',
                'tempat_lahir'         => 'Bandung',
                'tgl_lahir'            => '2005-09-05',
                'jenis_kelamin'        => 'L',
                'kebangsaan'           => 'Indonesia',

                // 🏠 Data pribadi & kontak
                'alamat_rumah'         => 'Jl. Sukajadi No. 45, Bandung',
                'kode_pos_rumah'       => '40162',
                'telepon_rumah'        => null,
                'telepon_hp'           => '089612345678',
                'email'                => 'reno@gmail.com',

                // 🎓 Data pendidikan
                'kualifikasi_pendidikan' => 'SMK - Desain Komunikasi Visual',

                // 💼 Data pekerjaan sekarang
                'nama_institusi'       => 'SMKN 11 Bandung',
                'jabatan'              => 'Siswa Program Keahlian DKV',
                'alamat_kantor'        => 'Jl. Budhi No. 1, Pamoyanan, Cicendo, Kota Bandung',
                'kode_pos_kantor'      => '40173',
                'telepon_kantor'       => '(022) 6023456',
                'fax_kantor'           => null,
                'email_kantor'         => 'info@smkn11bandung.sch.id',

                'created_at'           => Carbon::now(),
                'updated_at'           => Carbon::now(),
            ],
        ]);
    }
}