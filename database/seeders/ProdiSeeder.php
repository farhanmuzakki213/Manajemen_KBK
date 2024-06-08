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
            [7, '4EC', 'D4 - Teknik Elektronika', 4, 'D4'],
            [18, '3MI', 'Manajemen Informatika D-3', 7, 'D3'],
            [19, '3TK', 'Teknik Komputer D-3', 7, 'D3'],
            [20, '4TRPL', 'Teknologi Rekayasa Perangkat Lunak', 7, 'D4'],
            [21, '3SI-TD', 'D-3 SISTEM INFORMASI (TANAH DATAR)', 7, 'D3'],
            [22, '3TK-SS', 'D-3 Teknik Komputer (Solok Selatan)', 7, 'D3'],
            [23, '3MI-P', 'Manajemen Informatika (Pelalawan)', 7, 'D3']
        ];

        foreach ($prodiData as $data) {
            DB::table('prodi')->insert([
                'id_prodi' => $data[0],
                'kode_prodi' => $data[1],
                'prodi' => $data[2],
                'jurusan_id' => $data[3],
                'jenjang' => $data[4]
            ]);
        }
    }
}
