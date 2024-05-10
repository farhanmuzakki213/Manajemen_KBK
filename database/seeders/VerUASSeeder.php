<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerUASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $VerUASData = [
            [1, 357, '', 1, '', '2023-12-25'],
            [2, 220, '', 1, '', '2024-02-12']
        ];

        foreach ($VerUASData as $data) {
            DB::table('ver_uas')->insert([
                'id_ver_uas' => $data[0],
                'dosen_id' => $data[1],
                'file' => $data[2],
                'status_ver_uas' => $data[3],
                'catatan' => $data[4],
                'tanggal_diverifikasi' => $data[5]
            ]);
        }
    }
}
