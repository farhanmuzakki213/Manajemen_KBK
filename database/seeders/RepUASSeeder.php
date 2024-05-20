<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RepUASSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $RepUASData = [
            [1, 3, 66, 13, '', '2024-01-30', '2024-01-30'],
            [2, 3, 85, 14, '', '2024-02-28', '2024-02-28']
        ];

        foreach ($RepUASData as $data) {
            DB::table('rep_uas')->insert([
                'id_rep_uas' => $data[0],
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
