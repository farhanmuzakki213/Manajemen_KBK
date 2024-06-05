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
            [1, '14', 2],
            [1, '15', 2],
            [2, '16', 2],
            [2, '17', 2],
            [3, '18', 2],
            [3, '19', 2],
            [3, '20', 2],
            [4, '21', 2],
            [4, '22', 2],
            [5, '23', 2],
            [5, '24', 2],
            [6, '25', 2],
            [6, '26', 2],
            [7, '27', 2],
            [7, '28', 2],
            [8, '29', 2],
        ];

        foreach ($dosenMatkulDataDetail as $data) {
            DB::table('dosen_matkul_detail_pivot')->insert([
                'dosen_matkul_id' => $data[0],
                'matkul_id' => $data[1],
                'kelas_id' => $data[2],
            ]);
        }
    }
}
