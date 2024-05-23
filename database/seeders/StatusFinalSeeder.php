<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StatusFinalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $StatusData = [
            [1, 487, 'lulus'],
            [2, 729, 'lulus']
        ];

        foreach ($StatusData as $data) {
            DB::table('status_final')->insert([
                'id_status' => $data[0],
                'proposal_ta_id' => $data[1],
                'status_final' => $data[2]
            ]);
        }
    }
}
