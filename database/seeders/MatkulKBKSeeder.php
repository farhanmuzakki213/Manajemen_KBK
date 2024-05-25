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
            [2, 13, 5, 5],
            [3, 16, 5, 5],
            [4, 17, 5, 5],
            [5, 18, 5, 5],
            [6, 19, 5, 5],
            [7, 20, 5, 5],
            [8, 21, 5, 5],
            [9, 22, 5, 5],
            [10, 23, 5, 5],
            [11, 24, 5, 5],
            [12, 25, 5, 5],
            [13, 26, 3, 6],
            [14, 27, 2, 6],
            [15, 28, 1, 7],
            [16, 29, 3, 7],
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
