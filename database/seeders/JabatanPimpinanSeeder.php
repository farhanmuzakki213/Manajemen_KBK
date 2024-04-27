<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JabatanPimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $JPData = [
            [1, 'Ketua Jurusan', 'KAJUR', '1'],
            [2, 'Sekretaris Jurusan', 'SEKJUR', '1'],
            [3, 'Koordinator Program', 'KAPRODI', '1']
        ];

        foreach ($JPData as $data) {
            DB::table('jabatan_pimpinan')->insert([
                'id_jabatan_pimpinan' => $data[0],
                'jabatan_pimpinan' => $data[1],
                'kode_jabatan_pimpinan' => $data[2],
                'status' => $data[3]
            ]);
        }
    }
}
