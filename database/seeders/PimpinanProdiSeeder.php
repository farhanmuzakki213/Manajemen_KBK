<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PimpinanProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PPData = [
            [1, 3, 20, 160, '2022-2026', '1'],
            [2, 3, 18, 351, '2022-2026', '1'],
            [3, 3, 19, 312, '2022-2026', '1'],
        ];

        foreach ($PPData as $data) {
            DB::table('pimpinan_prodi')->insert([
                'id_pimpinan_prodi' => $data[0],
                'jabatan_pimpinan_id' => $data[1],
                'prodi_id' => $data[2],
                'dosen_id' => $data[3],
                'periode' => $data[4],
                'status_pimpinan_prodi' => $data[5]
            ]);
        }
    }
}
