<?php

namespace Database\Seeders;

use App\Models\ReviewProposalTaDetailPivot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewProposalTADetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Detail = [
            
        ];

        foreach ($Detail as $data) {
            DB::table('review_proposal_ta_detail_pivot')->insert([
                'penugasan_id' => $data[0],
                'dosen' => $data[1],
                'status_review_proposal' => $data[2],
                'catatan' => $data[3],
                'tanggal_review' => $data[4]
            ]);
        }
    }
}