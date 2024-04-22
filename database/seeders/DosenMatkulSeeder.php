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
            [21, 1, 1, 3],
            [7, 1, 2, 3]
        ];

        foreach ($dosenMatkulData as $data) {
            DB::table('dosen_matkul')->insert([
                'dosen_id' => $data[0],
                'matkul_id' => $data[1],
                'kelas_id' => $data[2],
                'smt_thnakd_id' => $data[3]
            ]);
        }
    }
}
