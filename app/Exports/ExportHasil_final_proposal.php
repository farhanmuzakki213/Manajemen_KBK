<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportHasil_final_proposal implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data_final_proposal_ta = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as reviewer_satu', 'review_proposal_ta.reviewer_satu', '=', 'reviewer_satu.id_dosen')
            ->join('dosen as reviewer_dua', 'review_proposal_ta.reviewer_dua', '=', 'reviewer_dua.id_dosen')
            ->join('dosen as pembimbing_satu', 'proposal_ta.pembimbing_satu', '=', 'pembimbing_satu.id_dosen')
            ->join('dosen as pembimbing_dua', 'proposal_ta.pembimbing_dua', '=', 'pembimbing_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select(
                'mahasiswa.nama',
                'mahasiswa.nim',
                'proposal_ta.judul',
                'reviewer_satu.nama_dosen as reviewer_satu_nama',
                'reviewer_dua.nama_dosen as reviewer_dua_nama',
                'review_proposal_ta.status_final_proposal',
                'pembimbing_satu.nama_dosen as pembimbing_satu_nama',
                'pembimbing_dua.nama_dosen as pembimbing_dua_nama'
            )
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get()
            ->map(function ($item) {
                // Ubah nilai status_final_proposal
                $item->status_final_proposal = $item->status_final_proposal == 0 ? 'Belum Final' : 'Final';
                return $item;
            });

        return $data_final_proposal_ta;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'nama_mahasiswa',
            'nim',
            'judul',
            'pembimbing_1',
            'pembimbing_2',
            'status_final',
            'reviewer_1',
            'reviewer_2'
        ];
    }
}
