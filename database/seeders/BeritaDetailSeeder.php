<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $BeritaData = [
        ];

        foreach ($BeritaData as $data) {
            DB::table('ver_berita_acara_detail_pivot')->insert([
                'berita_acara_id' => $data[0],
                'ver_rps_uas_id' => $data[1],
            ]);
        }
    }
}