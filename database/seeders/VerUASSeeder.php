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
            [36, '', 'diverifikasi', '', '2023-12-25'],
            [21, '', 'diverifikasi', '', '2024-02-12'],
        ];

        foreach ($VerUASData as $data) {
            DB::table('ver_uas')->insert([
                'dosen_id' => $data[0],
                'file' => $data[1],
                'status' => $data[2],
                'catatan' => $data[3],
                'tanggal_diverifikasi' => $data[4]
            ]);
        }
    }
}
