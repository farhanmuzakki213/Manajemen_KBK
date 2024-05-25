<?php

namespace App\Http\Controllers;

use App\Exports\ExportHasil_final_proposal;
use App\Models\ReviewProposalTAModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class HAsilFinalProposalTAController extends Controller
{
    
    public function index()
    {
        $data_review_proposal_ta = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as reviewer_satu', 'review_proposal_ta.reviewer_satu', '=', 'reviewer_satu.id_dosen')
            ->join('dosen as reviewer_dua', 'review_proposal_ta.reviewer_dua', '=', 'reviewer_dua.id_dosen')
            ->join('dosen as pembimbing_satu', 'proposal_ta.pembimbing_satu', '=', 'pembimbing_satu.id_dosen')
            ->join('dosen as pembimbing_dua', 'proposal_ta.pembimbing_dua', '=', 'pembimbing_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select('review_proposal_ta.*', 'proposal_ta.*', 'mahasiswa.*', 'reviewer_satu.nama_dosen as reviewer_satu_nama', 'reviewer_dua.nama_dosen as reviewer_dua_nama', 'pembimbing_satu.nama_dosen as pembimbing_satu_nama', 'pembimbing_dua.nama_dosen as pembimbing_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        debug($data_review_proposal_ta);
        return view('admin.content.hasil_review_proposal_ta', compact('data_review_proposal_ta'));
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
        Session::flash('error', 'Status Review Proposal belum Di Terima');
        return redirect()->route('hasil_review_proposal_ta');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        {
            $validator = Validator::make($request->all(), [
                'id_penugasan' => 'required',
                'status' => 'required',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $data = [
                'id_penugasan' => $request->id_penugasan,
                'status_final_proposal' => $request->status,
            ];
            //dd($request->all());
            ReviewProposalTAModel::where('id_penugasan', $id)->update($data);
            return redirect()->route('hasil_review_proposal_ta')->with('success', 'Data berhasil diperbarui.');
        }
    }
    
    public function export_excel(){
        return Excel::download(new ExportHasil_final_proposal, "hasil_final_proposal.xlsx");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
