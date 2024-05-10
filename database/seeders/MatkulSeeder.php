<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matkulData = [
            ['13', 'RPL3205', 'Pengantar Rekayasa Perangkat Lunak', 'T', 2, 2, 2, 0, 2, 0, 2, 5, 3],
            ['14', 'RPL3403', 'Kecerdasan Buatan', 'T/P', 3, 5, 2, 1, 2, 3, 4, 5, 3],
            ['15', 'RPL3401', 'Pemrograman Web Framework', 'P', 2, 6, 0, 2, 0, 6, 4, 5, 2]
        ];

        foreach ($matkulData as $data) {
            DB::table('matkul')->insert([
                'id_matkul' => $data[0],
                'kode_matkul' => $data[1],
                'nama_matkul' => $data[2],
                'TP' => $data[3],
                'sks' => $data[4],
                'jam' => $data[5],
                'sks_teori' => $data[6],
                'sks_praktek' => $data[7],
                'jam_teori' => $data[8],
                'jam_praktek' => $data[9],
                'semester' => $data[10],
                'kurikulum_id' => $data[11],
                'smt_thnakd_id' => $data[12]
            ]);
        }
    }
}
