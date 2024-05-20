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
            [2, 'TRPL1B', 'TRPL 1B', 20, 3]
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
