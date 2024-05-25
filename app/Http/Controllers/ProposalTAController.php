<?php

namespace App\Http\Controllers;

use App\Models\ProposalTAModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProposalTAController extends Controller
{
    
    public function index()
    {
        $data_proposal_ta = DB::table('proposal_ta')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->join('dosen as dosen_satu', 'proposal_ta.pembimbing_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'proposal_ta.pembimbing_dua', '=', 'dosen_dua.id_dosen')
            ->select('proposal_ta.*', 'mahasiswa.*', 'dosen_satu.nama_dosen as pembimbing_satu', 'dosen_dua.nama_dosen as pembimbing_dua')
            ->orderByDesc('proposal_ta.id_proposal_ta')
            ->get();


        debug($data_proposal_ta);
        return view('admin.content.Proposal_ta', compact('data_proposal_ta'));
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
        $data_dosen = DB::table('dosen')->get();
        $data_mahasiswa = DB::table('mahasiswa')->get();


        return view('admin.content.Proposal_ta', compact('data_dosen', 'data_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_review_proposal_ta = ProposalTAModel::where('id_penugasan', $id)
            /* ->join('dosen as dosen_satu', 'review_proposal_ta.reviewer_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'review_proposal_ta.reviewer_dua', '=', 'dosen_dua.id_dosen')
            ->select('review_proposal_ta.*', 'dosen_satu.nama_dosen as reviewer_satu_nama', 'dosen_dua.nama_dosen as reviewer_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
             */->first();
        debug(compact('data_dosen', 'data_review_proposal_ta'));
        return view('admin.content.form.review_proposal_ta_edit', compact('data_dosen', 'data_review_proposal_ta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_penugasan' => 'required',
            'status' => 'required',
            'catatan',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'id_penugasan' => $request->id_penugasan,
            'status_review_proposal' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_review' => $request->date,
        ];
        //dd($request->all());
        ProposalTAModel::where('id_penugasan', $id)->update($data);
        return redirect()->route('review_proposal_ta')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
