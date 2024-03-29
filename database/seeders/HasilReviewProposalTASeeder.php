<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HasilReviewProposalTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $HasilData = [
            [1, 'Lulus', '', '2024-03-17'],
            [2, 'Lulus', '', '2024-02-18']
        ];

        foreach ($HasilData as $data) {
            DB::table('hasil_review_proposal_ta')->insert([
                'penugasan_id' => $data[0],
                'hasil' => $data[1],
                'catatan' => $data[2],
                'tanggal_review' => $data[3]
            ]);
        }
    }
}
