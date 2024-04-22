<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ThnakdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('smt_thnakd')->insert([
            [
                'smt_thnakd' => '2022/2023-Genap',
                'status' => '0',
            ],
            [
                'smt_thnakd' => '2023/2024-Ganjil',
                'status' => '0',
            ],
            [
                'smt_thnakd' => '2023/2024-Genap',
                'status' => '1',
            ]
        ]);
    }
}
