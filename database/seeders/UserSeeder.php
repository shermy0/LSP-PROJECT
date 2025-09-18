<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 3,
                'name' => 'Reno Susanto',
                'email' => 'reno@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$ijOzUxuJVc4aQ3vaRAMJTeDORQDgtK.wNRmUUw7..d5E3cBaseohu',
                'role' => 'asesi',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-03 19:01:25',
                'updated_at' => '2025-09-03 19:01:25'
            ],
            [
                'id' => 4,
                'name' => 'Martendi',
                'email' => 'Martendi@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$KQqkqcCa2zaVLKzlxjoyku5D/bmMd5.PGytROZ6szpOYFwMmfFV62',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-03 19:01:25',
                'updated_at' => '2025-09-03 19:01:25'
            ],
            [
                'id' => 5,
                'name' => 'Usep Nurjaman',
                'email' => 'usep.nurjaman@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$pnXaYkBNqGt8Xz0ODdCXpek55PZyO.e1mjTwCNO4f6Xq0AjnyfgXG',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 6,
                'name' => 'Ade Sarkosih',
                'email' => 'ade.sarkosih@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$HBr.oEwf/tGFubRKNxBOMuyQQrIUCzw3xhgQT2rI7ShgBvY531l0S',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 7,
                'name' => 'Santi Yulianasari',
                'email' => 'santi.yulianasari@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$JbW3E1oItI4FslnjKnEtg.8/QarpV7EOEqRD8Bk49n.vky52FmBW2',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 8,
                'name' => 'Elies Diaty',
                'email' => 'elies.diaty@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$dQnZbL7SPc36fPSCT92j4eZ./hmBYgxT1lWQUamRFsPyCA8Gf54AG',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 9,
                'name' => 'Parwanto',
                'email' => 'parwanto@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$nrrEOZX/o10leEshejOLb.xuGH9RaAkv0TmE/oF5Pi2wgv3Lcnbyy',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 10,
                'name' => 'Hj. Rodiyah',
                'email' => 'rodiyah@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$VNVeM7htX/l4WUVC4FVPD.1TD4lGxcCIJpovN/iDtmH2v6pzNhFFi',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 11,
                'name' => 'Ratna Suminar',
                'email' => 'ratna.suminar@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$knCgfpg9cHenzCs9LyBLO.Yf/z1vB8pElmRrOlYUnsSYUynArZamO',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 12,
                'name' => 'Zimzim Al Amin Syahid',
                'email' => 'zimzim.syahid@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$Lk07BzVnAJoOO3iqF.x1ouIoYxeIAn8K3.IVk8gnBGsc59jTXH2t2',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 13,
                'name' => 'Ade Suryadi',
                'email' => 'ade.suryadi@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$ZSSJN2Qvtg9DUx/GU8zm2un1whRglyjukmBGcclyc1Yzk2IvLrDsa',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 14,
                'name' => 'Sutarsa',
                'email' => 'sutarsa@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$kShOBqHfzVF69OziNqYqGOIYoyyw9oK.2Tr5X0ZBBiIq1cpsbTKoi',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 15,
                'name' => 'Lilis Nurlela',
                'email' => 'lilis.nurlela@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$hnQAQP1sNVR7tUc6aGmWVeo6TSYen0KoxntPx23k/uGoWvCu1s7ky',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 16,
                'name' => 'Risna Maelani',
                'email' => 'risna.maelani@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$3pnGNccOos5OX8CjocwV4.J03hkPv9jYhFPxC4cIxNgOY9sZNtEUG',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 17,
                'name' => 'Tatang Tahyan',
                'email' => 'tatang.tahyan@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$DYrhHRdX1hvlxNC99sQpge5szU68PLWFT5qEw/F6zSIZZ095.5JZm',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 18,
                'name' => 'Yudi Subekti',
                'email' => 'yudi.subekti@gmail.com',
                'email_verified_at' => null,
                'password' => 'yudisubekti123', // Note: This appears to be plain text, consider hashing
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 19,
                'name' => 'Himatul Munawaroh',
                'email' => 'himatul.munawaroh@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$0jTSmegAY5yPHdPuu9PI7OSpOAektc1hxH/TsouAAcgPCkZXPi5IG',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 20,
                'name' => 'Ani Nuraeni',
                'email' => 'ani.nuraeni@gmail.com',
                'email_verified_at' => null,
                'password' => 'aninuraeni123', // Note: This appears to be plain text, consider hashing
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 21,
                'name' => 'Dedi Suryadi',
                'email' => 'dedi.suryadi@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$WqB0HzVvHksJ7ArhPB8.g.R2YBFOyQZV.LZ7SP.zjQkaPESbhcuwi',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 22,
                'name' => 'Regina Agustini',
                'email' => 'regina.agustini@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$WqB0HzVvHksJ7ArhPB8.g.R2YBFOyQZV.LZ7SP.zjQkaPESbhcuwi',
                'role' => 'asesor',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => '2025-09-04 04:32:24',
                'updated_at' => '2025-09-04 04:32:24'
            ],
            [
                'id' => 23,
                'name' => 'Admin LSP',
                'email' => 'adminlsp@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$Oh3Mo8FtQBqyGqPmDqI1e.CQeglsROlpn1/T5dvxn2HAYJLRzAuiO',
                'role' => 'admin',
                'profile_photo' => null,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null
            ]
        ]);
    }
}