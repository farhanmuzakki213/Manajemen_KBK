<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HakAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $HAData = [
            [1, 'Super Admin', ''],
            [2, 'Pengguna', ''],
            [3, 'Admin', ''],
            [4, 'Dosen Pengampu', ''],
            [5, 'Pengurus KBK', ''],
            [6, 'Dosen KBK', ''],
            [7, 'Pimpinan Program Studi', ''],
            [8, 'Pimpinan Jurusan', '']
        ];

        foreach ($HAData as $data) {
            DB::table('hak_akses')->insert([
                'id_hak_akses' => $data[0],
                'hak_akses' => $data[1],
                'deskripsi' => $data[2]
            ]);
        }
    }
}
