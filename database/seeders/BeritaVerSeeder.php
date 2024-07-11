<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BeritaVerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $BeritaData = [
            
        ];

        foreach ($BeritaData as $data) {
            DB::table('ver_berita_acara')->insert([
                'id_berita_acara' => $data[0],
                'kajur' => $data[1],
                'kaprodi' => $data[2],
                'jenis_kbk_id' => $data[3],
                'file_berita_acara' => $data[4],
                'Status_dari_kaprodi' => $data[5],
                'Status_dari_kajur' => $data[6],
                'type' => $data[7],
                'tanggal_disetujui_kaprodi' => $data[8],
                'tanggal_diketahui_kajur' => $data[9],
                'tanggal_upload' => $data[10],
            ]);
        }
    }
}
