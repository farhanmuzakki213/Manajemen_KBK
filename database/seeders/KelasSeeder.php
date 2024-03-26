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
            ['TRPL1A', 'TRPL 1A', 3, 1],
            ['TRPL1B', 'TRPL 1B', 3, 3]
        ];

        foreach ($kelasData as $data) {
            DB::table('kelas')->insert([
                'kode_kelas' => $data[0],
                'nama_kelas' => $data[1],
                'prodi_id' => $data[2],
                'smt_thnakd_id' => $data[3]
            ]);
        }
    }
}
