<?php

namespace App\Exports;

use App\Models\PimpinanProdi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewProposalTaDetailPivot;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportHasil_final_proposal implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $kaprodi = PimpinanProdi::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $kaprodi;
    }


    public function collection()
    {
        $kaprodi = $this->getDosen();
        // Mengambil data dengan join
        $data_final_proposal_ta = ReviewProposalTaDetailPivot::with([
            'p_reviewProposal.proposal_ta.r_mahasiswa',
            'p_reviewProposal.proposal_ta.r_pembimbing_satu',
            'p_reviewProposal.proposal_ta.r_pembimbing_dua',
            'p_reviewProposal.reviewer_satu_dosen.r_dosen',
            'p_reviewProposal.reviewer_dua_dosen.r_dosen'
        ])
            ->whereHas('p_reviewProposal', function ($query) use ($kaprodi) {
                $query->where('pimpinan_prodi_id', $kaprodi->id_pimpinan_prodi);
            })
            ->whereHas('p_reviewProposal', function ($query) {
                $query->where('status_final_proposal', '=', '3');
            })
            ->orderByDesc('penugasan_id')
            ->get()
            ->groupBy('penugasan_id');
            //dd($data_final_proposal_ta);
        // Ambil dua penugasan_id pertama
        $two_penugasan_ids = $data_final_proposal_ta->keys()->take(2);

        // Inisialisasi array untuk menyimpan data yang sudah digabungkan
        $merged_data = [];

        foreach ($two_penugasan_ids as $penugasan_id) {
            // Ambil data dari kelompok dengan penugasan_id tertentu
            $group = $data_final_proposal_ta[$penugasan_id];

            // Ambil data reviewer pertama dan kedua dari kelompok
            $reviewer_satu = $group->where('dosen', '1')->first();
            $reviewer_dua = $group->where('dosen', '2')->first();

            // Jika ada data reviewer pertama dan kedua, gabungkan dalam satu array
            if ($reviewer_satu && $reviewer_dua) {
                $merged_data[] = [
                    'nama_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nama,
                    'nim_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nim,
                    'judul' => $reviewer_satu->p_reviewProposal->proposal_ta->judul,
                    'pembimbing_satu' => $reviewer_satu->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                    'pembimbing_dua' => $reviewer_satu->p_reviewProposal->proposal_ta->r_pembimbing_dua->nama_dosen,
                    'reviewer_satu' => $reviewer_satu->p_reviewProposal->reviewer_satu_dosen->r_dosen->nama_dosen,
                    'reviewer_dua' => $reviewer_dua->p_reviewProposal->reviewer_dua_dosen->r_dosen->nama_dosen,
                    'status_final_proposal' => $reviewer_satu->p_reviewProposal->status_final_proposal == 3 ? 'Diterima' : '',
                ];
            }
        }

        return collect($merged_data);
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM Mahasiswa',
            'Judul',
            'Pembimbing Satu',
            'Pembimbing Dua',
            'Reviewer Satu',
            'Reviewer Dua',
            'Status Final Proposal'
        ];
    }
}
