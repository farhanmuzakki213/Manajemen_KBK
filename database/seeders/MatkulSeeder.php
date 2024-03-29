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
            ['RPL3205', 'Pengantar Rekayasa Perangkat Lunak', 'T', 2, 2, 2, 0, 2, 0, 2, 5],
            ['RPL3403', 'Kecerdasan Buatan', 'T/P', 3, 5, 2, 1, 2, 3, 4, 5],
            ['RPL3401', 'Pemrograman Web Framework', 'P', 2, 6, 0, 2, 0, 6, 4, 5]
        ];

        foreach ($matkulData as $data) {
            DB::table('matkul')->insert([
                'kode_matkul' => $data[0],
                'nama_matkul' => $data[1],
                'TP' => $data[2],
                'sks' => $data[3],
                'jam' => $data[4],
                'sks_teori' => $data[5],
                'sks_praktek' => $data[6],
                'jam_teori' => $data[7],
                'jam_praktek' => $data[8],
                'semester' => $data[9],
                'kurikulum_id' => $data[9]
            ]);
        }
    }
}
