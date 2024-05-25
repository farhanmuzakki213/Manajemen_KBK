<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KajurController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function RepProposalTAJurusan()
    {
        $data_rep_proposal_jurusan = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as reviewer_satu', 'review_proposal_ta.reviewer_satu', '=', 'reviewer_satu.id_dosen')
            ->join('dosen as reviewer_dua', 'review_proposal_ta.reviewer_dua', '=', 'reviewer_dua.id_dosen')
            ->join('dosen as pembimbing_satu', 'proposal_ta.pembimbing_satu', '=', 'pembimbing_satu.id_dosen')
            ->join('dosen as pembimbing_dua', 'proposal_ta.pembimbing_dua', '=', 'pembimbing_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('review_proposal_ta.*', 'proposal_ta.*', 'jurusan.*', 'prodi.*', 'mahasiswa.*', 'reviewer_satu.nama_dosen as reviewer_satu_nama', 'reviewer_dua.nama_dosen as reviewer_dua_nama', 'pembimbing_satu.nama_dosen as pembimbing_satu_nama', 'pembimbing_dua.nama_dosen as pembimbing_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        debug($data_rep_proposal_jurusan);
        return view('admin.content.rep_proposal_ta_jurusan', compact('data_rep_proposal_jurusan'));
    }

    public function RepRPSJurusan()
    {
        $data_rep_rps = DB::table('rep_rps')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            // ->join('ver_rps', 'rep_rps.ver_rps_id', '=', 'ver_rps.id_ver_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'rep_rps.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_rps.*', 'dosen.*','matkul.*','smt_thnakd.*')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_rep_rps')
            ->get();
            //dd($data_rep_rps);
        return view('admin.content.rep_RPS_jurusan', compact('data_rep_rps'));
    }

    public function RepSoalUASJurusan()
    {
        $data_rep_soal_uas = DB::table('ver_uas')
        ->join('dosen', 'ver_uas.dosen_id', '=', 'dosen.id_dosen')
        ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
        ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
        ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
        ->select('ver_uas.*', 'ver_uas.*', 'rep_uas.*', 'dosen.*', 'matkul.*', 'smt_thnakd.*')
        ->where('smt_thnakd.status_smt_thnakd', '=', '1')
        ->orderByDesc('id_ver_uas')
        ->get();
        debug($data_rep_soal_uas);
        return view('admin.content.rep_Soal_UAS_jurusan', compact('data_rep_soal_uas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
