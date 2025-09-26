<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'reno@gmail.com'],
            [
                'name' => 'Reno Susanto',
                'password' => bcrypt('password'),
                'role' => 'asesi',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'martendi@gmail.com'],
            [
                'name' => 'Martendi',
                'password' => bcrypt('password'),
                'role' => 'asesor',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'adminlsp@gmail.com'],
            [
                'name' => 'Admin LSP',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
