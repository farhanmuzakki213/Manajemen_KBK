<?php

namespace App\Http\Controllers\DosenKbk;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProposalTAModel;
use App\Models\ReviewProposalTaDetailPivot;
use Barryvdh\Debugbar\Facades\Debugbar as FacadesDebugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewProposalTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal')
            ->orderByDesc('review_proposal_ta_detail_pivot.penugasan_id')
            ->get();


        debug($data_review_proposal_ta);
        return view('admin.content.dosenKbk.review_proposal_ta', compact('data_review_proposal_ta'));
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
        $data_dosen = Dosen::all();
        $data_mahasiswa = Mahasiswa::all();
        $data_proposal_ta = ProposalTAModel::all();
        return view('admin.content.dosenKbk.review_proposal_ta', compact('data_dosen', 'data_proposal_ta', 'data_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = Dosen::all();
        $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal.reviewer_dua_dosen.r_dosen', 'p_reviewProposal.reviewer_satu_dosen.r_dosen')->where('penugasan_id', $id)
                                                      ->first();
            /* ->join('dosen as dosen_satu', 'review_proposal_ta.reviewer_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'review_proposal_ta.reviewer_dua', '=', 'dosen_dua.id_dosen')
            ->select('review_proposal_ta.*', 'dosen_satu.nama_dosen as reviewer_satu_nama', 'dosen_dua.nama_dosen as reviewer_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            */
        debug(compact('data_dosen', 'data_review_proposal_ta'));
        return view('admin.content.dosenKbk.form.review_proposal_ta_edit', compact('data_dosen', 'data_review_proposal_ta'));
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
            'penugasan_id' => $request->id_penugasan,
            'status_review_proposal' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_review' => $request->date,
        ];
        //dd($request->all());
        ReviewProposalTaDetailPivot::where('penugasan_id', $id)->update($data);
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
