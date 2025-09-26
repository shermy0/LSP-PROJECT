<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->updateOrInsert(
    ['id_admin' => 1],
    [
        'user_id' => 3, // harus cocok dengan tabel users
        'nama_admin' => 'Admin LSP',
        'email' => 'adminlsp@gmail.com',
        'nip' => '1234567890',
        'no_registrasi' => 'REG001',
        'created_at' => now(),
        'updated_at' => now(),
    ]
);

    }
}