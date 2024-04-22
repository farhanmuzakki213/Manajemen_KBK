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
            ['Ketua Jurusan', 'KAJUR', '1'],
            ['Sekretaris Jurusan', 'SEKJUR', '1'],
            ['Koordinator Program', 'KAPRODI', '1']
        ];

        foreach ($JPData as $data) {
            DB::table('jabatan_pimpinan')->insert([
                'jabatan_pimpinan' => $data[0],
                'kode_jabatan_pimpinan' => $data[1],
                'status' => $data[2]
            ]);
        }
    }
}
