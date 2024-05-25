<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewProposalTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PenugasanData = [
            [1, 487, 122, 127, '1', NULL, '2024-01-17', '2024-01-17'],
            [2, 729, 361, 160, '1', NULL, '2024-02-18', '2024-02-18'],
            [3, 684, 361, 127, '0', NULL, '2024-02-19', '2024-02-19'],
            [4, 594, 361, 160, '3', NULL, '2024-04-20', '2024-04-20'],
            [5, 344, 361, 127, '2', NULL, '2024-04-22', '2024-04-22'],
            [6, 182, 361, 160, '3', NULL, '2024-04-25', '2024-04-25'],
        ];

        foreach ($PenugasanData as $data) {
            $prefix = 'PR';
            $nextNumber = $this->getNextNumber($prefix);
            DB::table('review_proposal_ta')->insert([
                'id_penugasan' => $prefix . $nextNumber,
                'proposal_ta_id' => $data[1],
                'reviewer_satu' => $data[2],
                'reviewer_dua' => $data[3],
                'status_review_proposal' => $data[4],
                'catatan' => $data[5],
                'tanggal_penugasan' => $data[6],
                'tanggal_review' => $data[7]
            ]);
        }
    }
    private function getNextNumber($prefix)
    {
        // Ambil ID terakhir dengan prefix yang sama
        $lastEntry = DB::table('review_proposal_ta')
            ->where('id_penugasan', 'like', $prefix . '%')
            ->orderBy('id_penugasan', 'desc')
            ->first();

        // Jika tidak ada entri sebelumnya, kembalikan angka pertama
        if (!$lastEntry) {
            return 1;
        }

        // Ambil angka terakhir dari ID terakhir dan tambahkan 1
        $lastNumber = intval(substr($lastEntry->id_penugasan, strlen($prefix)));
        return $lastNumber + 1;
    }
}
