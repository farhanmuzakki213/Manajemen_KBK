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
            [3, 3, 17, '2022-2026', '1']
        ];

        foreach ($PPData as $data) {
            DB::table('pimpinan_prodi')->insert([
                'jabatan_pimpinan_id' => $data[0],
                'prodi_id' => $data[1],
                'dosen_id' => $data[2],
                'periode' => $data[3],
                'status' => $data[4]
            ]);
        }
    }
}
