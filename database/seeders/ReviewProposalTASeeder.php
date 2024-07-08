<?php

namespace Database\Seeders;

use App\Models\ReviewProposalTAModel;
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
        ];

        foreach ($PenugasanData as $data) {
            $nextNumber = $this->getCariNomor();
            DB::table('review_proposal_ta')->insert([
                'id_penugasan' => $nextNumber,
                'proposal_ta_id' => $data[0],
                'pengurus_id' => $data[1],
                'reviewer_satu' => $data[2],
                'reviewer_dua' => $data[3],
                'pimpinan_prodi_id' => $data[4],
                'status_final_proposal' => $data[5],
                'tanggal_penugasan' => $data[6]
            ]);
        }
    }
    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_penugasan = ReviewProposalTAModel::pluck('id_penugasan')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_penugasan)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
