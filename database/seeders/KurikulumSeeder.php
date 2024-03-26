<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kurikulumData = [
            ['KUR TRPL 2017', 'Kurikulum TRPL 2017', 2017, 3, '0'],
            ['KUR TRPL  2017 REV', 'Kurikulum TRPL 2017 Revisi', 2020, 3, '0'],
            ['KUR TRPL 2022', 'Kurikulum TRPL 2022', 2022, 3, '1'],
            ['KUR TRPL 2022 V.1', 'Kurikulum TRPL 2022 Versi 1', 2023, 3, '1'],
            ['KUR TRPL  2022 V.2', 'Kurikulum TRPL 2022 Versi 2', 2024, 3, '1']
        ];

        foreach ($kurikulumData as $data) {
            DB::table('kurikulum')->insert([
                'kode_kurikulum' => $data[0],
                'nama_kurikulum' => $data[1],
                'tahun' => $data[2],
                'prodi_id' => $data[3],
                'status' => $data[4]
            ]);
        }
    }
}
