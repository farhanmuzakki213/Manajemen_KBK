<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProposalTASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proposalData = [
            ['Web Framework', 1, '', '', '2024-01-30', '2024-01-30'],
            ['PBL Semester 4', 5, '', '', '2024-02-28', '2024-02-28']
        ];

        foreach ($proposalData as $data) {
            DB::table('proposal_ta')->insert([
                'judul' => $data[0],
                'mahasiswa_id' => $data[1],
                'file' => $data[2],
                'deskripsi' => $data[3],
                'created_at' => $data[4],
                'updated_at' => $data[5]
            ]);
        }
    }
}
