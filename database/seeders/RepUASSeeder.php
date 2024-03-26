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
            [3, 1, 3, '', '2024-01-30', '2024-01-30'],
            [3, 2, 1, '', '2024-02-28', '2024-02-28']
        ];

        foreach ($RepUASData as $data) {
            DB::table('rep_uas')->insert([
                'smt_thnakd_id' => $data[0],
                'ver_uas_id' => $data[1],
                'matkul_id' => $data[2],
                'file' => $data[3],
                'created_at' => $data[4],
                'updated_at' => $data[5]
            ]);
        }
    }
}
