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
            ['13', 'RPL3205', 'Pengantar Rekayasa Perangkat Lunak', 'T', 2, 2, 2, 0, 2, 0, 2, 5],
            ['14', 'RPL3403', 'Kecerdasan Buatan', 'T/P', 3, 5, 2, 1, 2, 3, 4, 5],
            ['15', 'RPL3401', 'Pemrograman Web Framework', 'P', 2, 6, 0, 2, 0, 6, 3, 5],
            ['16', 'RPL3304', 'Rekayasa Kebutuhan Perangkat Lunak', 'T', 2, 2, 2, 0, 2, 0, 3, 5],
            ['17', 'RPL2303', 'Perancangan Antarmuka', 'T/P', 3, 5, 2, 1, 2, 3, 3, 5],
            ['18', 'RPL3402', 'Analisis Perancangan Perangkat Lunak', 'T/P', 5, 9, 3, 2, 3, 6, 4, 5],
            ['19', 'RPL3403', 'Proyek 1', 'P', 2, 6, 0, 2, 0, 6, 4, 5],
            ['20', 'RPL3501', 'Proyek 2', 'P', 2, 6, 0, 2, 0, 6, 5, 5],
            ['21', 'RPL3502', 'Pengujian dan Penjaminan Kualitas Perangkat Lunak', 'T/P', 4, 6, 3, 1, 3, 3, 5, 5],
            ['22', 'RPL3505', 'Kontruksi dan Evolusi Perangkat Lunak', 'T/P', 3, 5, 2, 1, 2, 3, 5, 5],
            ['23', 'RPL3602', 'Manajemen Proyek Perangkat Lunak', 'T/P', 4, 6, 3, 1, 3, 3, 6, 5],
            ['24', 'RPL3604', 'Proyek 3', 'P', 3, 9, 0, 3, 0, 9, 6, 5],
            ['25', 'RPL2601', 'Metodologi Penelitian', 'T', 3, 3, 3, 0, 3, 0, 6, 5],
            ['26', 'CEN3110', 'Komunikasi Data', 'T', 2, 2, 2, 0, 2, 0, 2, 6],
            ['27', 'CEN3304', 'Internet Of Things (IOT)', 'T/P', 3, 5, 2, 1, 2, 3, 4, 6],
            ['28', 'ISY3403', 'Pemrograman Mobile', 'T/P', 3, 5, 2, 1, 2, 3, 4, 7],
            ['29', 'ISY3405', 'Keamanan Sistem Informasi', 'T', 2, 2, 2, 0, 2, 0, 4, 7]
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
                'kurikulum_id' => $data[11]
                // 'smt_thnakd_id' => $data[12]
            ]);
        }
    }
}
