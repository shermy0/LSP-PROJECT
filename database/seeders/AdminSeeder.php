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
        DB::table('admin')->insert([
            [
                'id_admin' => 1,
                'user_id' => 23,
                'nama_admin' => 'Admin LSP',
                'nip' => null,
                'email' => 'adminlsp@gmail.com',
                'no_registrasi' => null,
                'created_at' => '2025-09-04 04:46:36',
                'updated_at' => '2025-09-04 04:46:36'
            ]
        ]);
    }
}