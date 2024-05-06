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
            [1, 357, '', 1, '', '2023-12-25'],
            [2, 220, '', 1, '', '2024-02-12'],
        ];

        foreach ($VerRPSData as $data) {
            DB::table('ver_rps')->insert([
                'id_ver_rps' => $data[0],
                'dosen_id' => $data[1],
                'file' => $data[2],
                'status' => $data[3],
                'catatan' => $data[4],
                'tanggal_diverifikasi' => $data[5]
            ]);
        }
    }
}
