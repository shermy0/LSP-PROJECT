<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('migrations')->insert([
        //     [
        //         'id' => 1,
        //         'migration' => '0001_01_01_000000_create_users_table',
        //         'batch' => 1
        //     ],
        //     [
        //         'id' => 2,
        //         'migration' => '0001_01_01_000001_create_cache_table',
        //         'batch' => 1
        //     ],
        //     [
        //         'id' => 3,
        //         'migration' => '0001_01_01_000002_create_jobs_table',
        //         'batch' => 1
        //     ]
        // ]);
    }
}