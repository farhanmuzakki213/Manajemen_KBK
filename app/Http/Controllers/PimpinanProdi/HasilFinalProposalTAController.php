<?php

namespace App\Http\Controllers\PimpinanProdi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ReviewProposalTAModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\ExportHasil_final_proposal;
use App\Models\ReviewProposalTaDetailPivot;

class HAsilFinalProposalTAController extends Controller
{
    
    public function index()
    {
        $data_review_proposal_ta =  ReviewProposalTaDetailPivot::with('p_reviewProposal')
            ->orderByDesc('review_proposal_ta_detail_pivot.penugasan_id')
            ->get();

        debug($data_review_proposal_ta);
        return view('admin.content.pimpinanProdi.hasil_review_proposal_ta', compact('data_review_proposal_ta'));
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
