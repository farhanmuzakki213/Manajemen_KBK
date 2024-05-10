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
                'id_smt_thnakd' => '1',
                'kode_smt_thnakd' => '20222',
                'smt_thnakd' => '2022/2023-Genap',
                'status_smt_thnakd' => '0',
            ],
            [
                'id_smt_thnakd' => '2',
                'kode_smt_thnakd' => '20231',
                'smt_thnakd' => '2023/2024-Ganjil',
                'status_smt_thnakd' => '0',
            ],
            [
                'id_smt_thnakd' => '3',
                'kode_smt_thnakd' => '20232',
                'smt_thnakd' => '2023/2024-Genap',
                'status_smt_thnakd' => '1',
            ]
        ]);
    }
}
