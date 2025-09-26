<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asesi')->upsert(
            [
                [
                    'id_asesi' => 1,
                    'user_id' => 1, // id user Reno
                    'nama' => 'Reno Susanto',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ],
            ['id_asesi']
        );
    }
}