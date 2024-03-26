<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenugasanReviewerProposalTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PenugasanData = [
            [2, 14, '2024-03-17'],
            [1, 40, '2024-02-18']
        ];

        foreach ($PenugasanData as $data) {
            DB::table('penugasan_reviewer_proposal_ta')->insert([
                'proposal_ta_id' => $data[0],
                'dosen_id' => $data[1],
                'tanggal_penugasan' => $data[2]
            ]);
        }
    }
}
