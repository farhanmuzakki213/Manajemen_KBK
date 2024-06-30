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
            [1, 14,  20 ,1, 5],
            [2, 13,  20 ,1, 5],
            [3, 16,  20 ,2, 5],
            [4, 17,  20 ,3, 5],
            [5, 18,  20 ,3, 5],
            [6, 19,  20 ,4, 5],
            [7, 20,  20 ,4, 5],
            [8, 21,  20 ,4, 5],
            [9, 22,  20 ,5, 5],
            [10, 23, 20 ,5, 5],
            [11, 24, 20 ,5, 5],
            [12, 25, 20 ,5, 5],
            [13, 26, 18 ,3, 6],
            [14, 27, 18 ,2, 6],
            [15, 28, 19 ,1, 7],
            [16, 29, 19 ,3, 7],
        ];

        foreach ($PPData as $data) {
            DB::table('matkul_kbk')->insert([
                'id_matkul_kbk' => $data[0],
                'matkul_id' => $data[1],
                'prodi_id' => $data[2],
                'jenis_kbk_id' => $data[3],
                'kurikulum_id' => $data[4]
            ]);
        }
    }
}
