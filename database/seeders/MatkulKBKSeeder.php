<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MatkulKBKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PPData = [
            [1, 14, 1, 5],
            [2, 13, 1, 5]
        ];

        foreach ($PPData as $data) {
            DB::table('matkul_kbk')->insert([
                'id_matkul_kbk' => $data[0],
                'matkul_id' => $data[1],
                'jenis_kbk_id' => $data[2],
                'kurikulum_id' => $data[3]
            ]);
        }
    }
}
