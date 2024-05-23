<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerRPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VerRPSData = [
            [1, 1, 357, '', '0', '', '2023-12-25'],
            [2, 2, 220, '', '0', '', '2024-02-12'],
        ];

        foreach ($VerRPSData as $data) {
            DB::table('ver_rps')->insert([
                'id_ver_rps' => $data[0],
                'rep_rps_id' => $data[1],
                'dosen_id' => $data[2],
                'file' => $data[3],
                'status_ver_rps' => $data[4],
                'catatan' => $data[5],
                'tanggal_diverifikasi' => $data[6]
            ]);
        }
    }
}
