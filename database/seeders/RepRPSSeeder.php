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
            [3, 1, 3, '', '2024-01-30', '2024-01-30'],
            [3, 2, 1, '', '2024-02-28', '2024-02-28']
        ];

        foreach ($RepRPSData as $data) {
            DB::table('rep_rps')->insert([
                'smt_thnakd_id' => $data[0],
                'ver_rps_id' => $data[1],
                'matkul_id' => $data[2],
                'file' => $data[3],
                'created_at' => $data[4],
                'updated_at' => $data[5]
            ]);
        }
    }
}
