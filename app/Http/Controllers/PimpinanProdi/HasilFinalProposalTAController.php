<?php

namespace App\Http\Controllers\PimpinanProdi;

use Illuminate\Http\Request;
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

            $grouped_data = $data_review_proposal_ta->groupBy('penugasan_id');

            // Ambil dua penugasan_id pertama
            $two_penugasan_ids = $grouped_data->keys()->take(2);
        
            // Inisialisasi array untuk menyimpan data yang sudah digabungkan
            $merged_data = [];
        
            foreach ($two_penugasan_ids as $penugasan_id) {
                // Ambil data dari kelompok dengan penugasan_id tertentu
                $group = $grouped_data[$penugasan_id];
        
                // Ambil data reviewer pertama dan kedua dari kelompok
                $reviewer_satu = $group->where('dosen', '1')->first();
                $reviewer_dua = $group->where('dosen', '2')->first();
        
                // Jika ada data reviewer pertama dan kedua, gabungkan dalam satu array
                if ($reviewer_satu && $reviewer_dua) {
                    $merged_data[] = [
                        'penugasan_id' => $penugasan_id,
                        'nama_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nama,
                        'nim_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nim,
                        'judul' => $reviewer_satu->p_reviewProposal->proposal_ta->judul,
                        'reviewer_satu' => $reviewer_satu->p_reviewProposal->reviewer_satu_dosen->r_dosen->nama_dosen,
                        'pembimbing_satu' => $reviewer_satu->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                        'reviewer_dua' => $reviewer_dua->p_reviewProposal->reviewer_dua_dosen->r_dosen->nama_dosen,
                        'pembimbing_dua' => $reviewer_dua->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                        'status_satu' => $reviewer_satu->status_review_proposal,
                        'status_dua' => $reviewer_dua->status_review_proposal,
                        'status_final_proposal' => $reviewer_dua->p_reviewProposal->status_final_proposal,
                    ];
                }
            }



        debug($data_review_proposal_ta->toArray(), $merged_data, $grouped_data->toArray());
        return view('admin.content.pimpinanProdi.hasil_review_proposal_ta', compact('merged_data'));
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
    { {
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

    public function export_excel()
    {
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
