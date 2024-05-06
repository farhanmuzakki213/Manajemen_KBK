<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DosenMatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenMatkulData = [
            [1, 220, 14, 1, 3],
            [2, 66, 15, 2, 3]
        ];

        foreach ($dosenMatkulData as $data) {
            DB::table('dosen_matkul')->insert([
                'id_dosen_matkul' => $data[0],
                'dosen_id' => $data[1],
                'matkul_id' => $data[2],
                'kelas_id' => $data[3],
                'smt_thnakd_id' => $data[4]
            ]);
        }
    }
}
