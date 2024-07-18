<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasData = [
            [1, 'TRPL1A', 'TRPL 1A', 20, 1],
            [2, 'TRPL1B', 'TRPL 1B', 20, 3],
            [3, 'TK1A', 'TK 1A', 19, 3],
            [4, 'TK1B', 'TK 1B', 19, 3],
            [5, 'TK2A', 'TK 2A', 19, 3],
            [6, 'TK2B', 'TK 2B', 19, 3],
            [7, 'TRPL2A', 'TRPL 2A', 20, 3],
            [8, 'TRPL2B', 'TRPL 2B', 20, 3],
            [9, 'TRPL2C', 'TRPL 2C', 20, 3],
            [10, 'TRPL2D', 'TRPL 2D', 20, 3],
            [11, 'TRPL1C', 'TRPL 1C', 20, 3],
            [12, 'TRPL1D', 'TRPL 1D', 20, 3],
        ];

        foreach ($kelasData as $data) {
            DB::table('kelas')->insert([
                'id_kelas' => $data[0],
                'kode_kelas' => $data[1],
                'nama_kelas' => $data[2],
                'prodi_id' => $data[3],
                'smt_thnakd_id' => $data[4]
            ]);
        }
    }
}
