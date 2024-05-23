<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewProposalTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_hasil_review_proposal_ta = DB::table('hasil_review_proposal_ta')
            ->join('penugasan_reviewer_proposal_ta', 'hasil_review_proposal_ta.penugasan_id', '=', 'penugasan_reviewer_proposal_ta.id_penugasan')
            ->join('proposal_ta', 'penugasan_reviewer_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen', 'penugasan_reviewer_proposal_ta.dosen_id', '=', 'dosen.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select('hasil_review_proposal_ta.*', 'penugasan_reviewer_proposal_ta.*', 'proposal_ta.*', 'mahasiswa.*', 'dosen.*')
            ->orderByDesc('id_hasil')
            ->get();

        debug($data_hasil_review_proposal_ta);
        return view('admin.content.review_proposal_ta', compact('data_hasil_review_proposal_ta'));
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
