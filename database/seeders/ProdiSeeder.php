<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiData = [
            ['3MI', 'Manajemen Informatika D-3', 7, 'D3'],
            ['3TK', 'Teknik Komputer D-3', 7, 'D3'],
            ['4TRPL', 'Teknologi Rekayasa Perangkat Lunak', 7, 'D4'],
            ['3SI-TD', 'D-3 Sistem Informasi (Tanah Datar)', 7, 'D3'],
            ['3TK-SS', 'D-3 Teknik Komputer (Solok Selatan)', 7, 'D3'],
            ['3MI-P', 'Manajemen Informatika (Pelalawan)', 7, 'D3']
        ];

        foreach ($prodiData as $data) {
            DB::table('prodi')->insert([
                'kode_prodi' => $data[0],
                'prodi' => $data[1],
                'jurusan_id' => $data[2],
                'jenjang' => $data[3]
            ]);
        }
    }
}
