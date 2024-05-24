<?php

namespace App\Http\Controllers;

use App\Models\ReviewProposalTAModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HAsilReviewProposalTAController extends Controller
{
    
    public function index()
    {
        $data_review_proposal_ta = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen', 'review_proposal_ta.dosen_id', '=', 'dosen.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select('review_proposal_ta.*', 'review_proposal_ta.*', 'proposal_ta.*', 'mahasiswa.*', 'dosen.*')
            ->orderByDesc('id_penugasan')
            ->get();

        debug($data_review_proposal_ta);
        return view('admin.content.hasil_review_proposal_ta', compact('data_review_proposal_ta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = DB::table('dosen')->get();
        $data_mahasiswa = DB::table('mahasiswa')->get();
        $data_proposal_ta = DB::table('proposal_ta')->get();

        return view('admin.content.hasil_review_proposal_ta', compact('data_dosen', 'data_proposal_ta', 'data_mahasiswa'));
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

        return view('admin.content.hasil_review_proposal_ta', compact('data_dosen', 'data_proposal_ta', 'data_mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_dosen = DB::table('dosen')->get();
        // $data_mahasiswa = DB::table('mahasiswa')->get();
        $data_proposal_ta = DB::table('proposal_ta')->get();
        $data_review_proposal_ta = ReviewProposalTAModel::where('id_hasil', $id)->first();

        debug(compact('data_dosen', 'data_proposal_ta', 'data_review_proposal_ta'));
        return view('admin.content.form.hasil_review_proposal_ta_edit', compact('data_dosen', 'data_proposal_ta', 'data_review_proposal_ta'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        {
            $validator = Validator::make($request->all(), [
                'id_penugasan' => 'required',
                'nama_dosen' => 'required',
                'status' => 'required',
                'catatan',
                'date' => 'required|date',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $data = [
                'id_penugasan' => $request->id_hasil,
                'dosen_id' => $request->nama_dosen,
                'status_review_proposal' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_review' => $request->date,
            ];
            //dd($request->all());
            ReviewProposalTAModel::where('id_penugasan', $id)->update($data);
            return redirect()->route('hasil_review_proposal_ta')->with('success', 'Data berhasil diperbarui.');
        }
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
