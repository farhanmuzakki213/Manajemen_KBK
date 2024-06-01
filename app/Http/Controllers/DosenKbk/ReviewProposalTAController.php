<?php

namespace App\Http\Controllers\DosenKbk;

use App\Http\Controllers\Controller;
use App\Models\ReviewProposalTAModel;
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
        $data_review_proposal_ta = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as dosen_satu', 'review_proposal_ta.reviewer_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'review_proposal_ta.reviewer_dua', '=', 'dosen_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select('review_proposal_ta.id_penugasan', 'review_proposal_ta.tanggal_penugasan', 'review_proposal_ta.tanggal_review', 'review_proposal_ta.status_review_proposal', 'proposal_ta.judul', 'mahasiswa.nama', 'dosen_satu.nama_dosen as reviewer_satu_nama', 'dosen_dua.nama_dosen as reviewer_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
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
        $data_dosen = DB::table('dosen')->get();
        $data_mahasiswa = DB::table('mahasiswa')->get();
        $data_proposal_ta = DB::table('proposal_ta')->get();

        return view('admin.content.dosenKbk.review_proposal_ta', compact('data_dosen', 'data_proposal_ta', 'data_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        $data_review_proposal_ta = ReviewProposalTAModel::where('id_penugasan', $id)
            /* ->join('dosen as dosen_satu', 'review_proposal_ta.reviewer_satu', '=', 'dosen_satu.id_dosen')
            ->join('dosen as dosen_dua', 'review_proposal_ta.reviewer_dua', '=', 'dosen_dua.id_dosen')
            ->select('review_proposal_ta.*', 'dosen_satu.nama_dosen as reviewer_satu_nama', 'dosen_dua.nama_dosen as reviewer_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
             */->first();
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
            'id_penugasan' => $request->id_penugasan,
            'status_review_proposal' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_review' => $request->date,
        ];
        //dd($request->all());
        ReviewProposalTAModel::where('id_penugasan', $id)->update($data);
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
