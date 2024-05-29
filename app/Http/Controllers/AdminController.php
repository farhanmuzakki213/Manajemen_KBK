<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function example(){
        return view('admin.content.example');
    }

    public function RepProposalTA()
    {
        $data_rep_proposal = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as reviewer_satu', 'review_proposal_ta.reviewer_satu', '=', 'reviewer_satu.id_dosen')
            ->join('dosen as reviewer_dua', 'review_proposal_ta.reviewer_dua', '=', 'reviewer_dua.id_dosen')
            ->join('dosen as pembimbing_satu', 'proposal_ta.pembimbing_satu', '=', 'pembimbing_satu.id_dosen')
            ->join('dosen as pembimbing_dua', 'proposal_ta.pembimbing_dua', '=', 'pembimbing_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('review_proposal_ta.id_penugasan', 'review_proposal_ta.tanggal_review', 'review_proposal_ta.status_review_proposal', 'proposal_ta.judul', 'review_proposal_ta.tanggal_penugasan', 'review_proposal_ta.status_final_proposal', 'jurusan.jurusan', 'prodi.prodi', 'mahasiswa.nama', 'mahasiswa.nim', 'reviewer_satu.nama_dosen as reviewer_satu_nama', 'reviewer_dua.nama_dosen as reviewer_dua_nama', 'pembimbing_satu.nama_dosen as pembimbing_satu_nama', 'pembimbing_dua.nama_dosen as pembimbing_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        return view('admin.content.rep_proposal_ta', compact('data_rep_proposal'));
    }

}
