<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PimpinanJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PJData = [
            [1, 7, 22, '2022-2026', '1'],
            [2, 7, 14, '2022-2026', '1']
        ];

        foreach ($PJData as $data) {
            DB::table('pimpinan_jurusan')->insert([
                'jabatan_pimpinan_id' => $data[0],
                'jurusan_id' => $data[1],
                'dosen_id' => $data[2],
                'periode' => $data[3],
                'status' => $data[4]
            ]);
        }
    }
}
