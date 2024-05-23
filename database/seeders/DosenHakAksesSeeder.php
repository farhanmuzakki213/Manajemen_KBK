<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DosenHakAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DHAData = [
            [1, 223, 8],
            [2, 160, 7]
        ];

        foreach ($DHAData as $data) {
            DB::table('dosen_hak_akses')->insert([
                'id_dosen_hak_akses' => $data[0],
                'dosen_id' => $data[1],
                'hak_akses_id' => $data[2]
            ]);
        }
    }
}