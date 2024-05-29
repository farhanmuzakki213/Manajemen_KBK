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
            [1, 1, 7, 223, '2022-2026', '1'],
            [2, 2, 7, 122, '2022-2026', '1']
        ];

        foreach ($PJData as $data) {
            DB::table('pimpinan_jurusan')->insert([
                'id_pimpinan_jurusan' => $data[0],
                'jabatan_pimpinan_id' => $data[1],
                'jurusan_id' => $data[2],
                'dosen_id' => $data[3],
                'periode' => $data[4],
                'status_pimpinan_jurusan' => $data[5]
            ]);
        }
    }
}
