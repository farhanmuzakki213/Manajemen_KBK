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
            [1, 'KUR TRPL 2017', 'Kurikulum TRPL 2017', 2017, 20, '0'],
            [2, 'KUR TRPL  2017 REV', 'Kurikulum TRPL 2017 Revisi', 2020, 20, '0'],
            [3, 'KUR TRPL 2022', 'Kurikulum TRPL 2022', 2022, 20, '1'],
            [4, 'KUR TRPL 2022 V.1', 'Kurikulum TRPL 2022 Versi 1', 2023, 20, '1'],
            [5, 'KUR TRPL  2022 V.2', 'Kurikulum TRPL 2022 Versi 2', 2024, 20, '1']

        ];

        foreach ($kurikulumData as $data) {
            DB::table('kurikulum')->insert([
                'id_kurikulum' => $data[0],
                'kode_kurikulum' => $data[1],
                'nama_kurikulum' => $data[2],
                'tahun' => $data[3],
                'prodi_id' => $data[4],
                'status_kurikulum' => $data[5]
            ]);
        }
    }
}
