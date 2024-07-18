<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenMatkulDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenMatkulDataDetail = [
            // [1, 1, 2],
            // [1, 2, 2],
            // [2, 3, 2],
            // [2, 4, 2],
            // [3, 5, 2],
            // [3, 6, 2],
            // [3, 7, 2],
            // [4, 8, 2],
            // [4, 9, 2],
            // [5, 10, 2],
            // [5, 11, 2],
            // [6, 12, 2],
            // [6, 13, 2],
            // [7, 14, 2],
            // [7, 17, 2],
            // [8, 16, 2],

            [2, 15, 3],
            [2, 15, 4],

            [3, 14, 3],
            [3, 14, 4],
            [3, 14, 5],
            [3, 14, 6],

            [5, 5, 7],
            [5, 5, 8],
            [5, 5, 9],
            [5, 5, 10],

            [6, 17, 7],
            [6, 17, 8],
            [6, 17, 9],

            [7, 1, 7],
            [7, 1, 8],
            [7, 1, 9],
            [7, 1, 10],
            [7, 2, 11],
            [7, 2, 12]
        ];

        foreach ($dosenMatkulDataDetail as $data) {
            DB::table('dosen_matkul_detail_pivot')->insert([
                'dosen_matkul_id' => $data[0],
                'matkul_kbk_id' => $data[1],
                'kelas_id' => $data[2],
            ]);
        }
    }
}
