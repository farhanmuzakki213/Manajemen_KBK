<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RepRPSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RepRPSData = [
            [1, 3, 40, 13, '', '2024-01-30', '2024-01-30'],
            [2, 3, 50, 14, '', '2024-02-28', '2024-02-28']
        ];

        foreach ($RepRPSData as $data) {
            DB::table('rep_rps')->insert([
                'id_rep_rps' => $data[0],
                'smt_thnakd_id' => $data[1],
                'dosen_id' => $data[2],
                'matkul_id' => $data[3],
                'file' => $data[4],
                'created_at' => $data[5],
                'updated_at' => $data[6]
            ]);
        }
    }
}
