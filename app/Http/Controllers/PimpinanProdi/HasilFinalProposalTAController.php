<?php

namespace App\Http\Controllers\PimpinanProdi;

use Illuminate\Http\Request;
use App\Models\PimpinanProdi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ReviewProposalTAModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\ExportHasil_final_proposal;
use App\Models\ReviewProposalTaDetailPivot;

class HAsilFinalProposalTAController extends Controller
{
    public function __construct() {
        $this->middleware('permission:pimpinanProdi-view ProposalTaFinal', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:pimpinanProdi-update ProposalTaFinal', ['only' => ['edit', 'update', 'getDosen']]);
        $this->middleware('permission:pimpinanProdi-export ProposalTaFinal', ['only' => ['export_excel', 'getDosen']]);
    }

    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $kaprodi = PimpinanProdi::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $kaprodi;
    }

    public function index()
    {
        $kaprodi = $this->getDosen();
        $data_ta = ReviewProposalTAModel::with('proposal_ta.r_pembimbing_satu', 'proposal_ta.r_pembimbing_dua', 'p_reviewDetail.p_reviewProposal')
        ->whereHas('p_reviewDetail.p_reviewProposal', function ($query) use ($kaprodi) {
            $query->where('pimpinan_prodi_id', $kaprodi->id_pimpinan_prodi);
        })
        ->get();
        $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal')
            ->whereHas('p_reviewProposal', function ($query) use ($kaprodi) {
                $query->where('pimpinan_prodi_id', $kaprodi->id_pimpinan_prodi);
            })
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

            // Inisialisasi variabel untuk menyimpan data reviewer
            $data_reviewer_satu = null;
            $data_reviewer_dua = null;

            // Periksa apakah ada data reviewer pertama
            if ($reviewer_satu) {
                $data_reviewer_satu = [
                    'reviewer_satu' => $reviewer_satu->p_reviewProposal->reviewer_satu_dosen->r_dosen->nama_dosen,
                    'pembimbing_satu' => $reviewer_satu->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                    'status_satu' => $reviewer_satu->status_review_proposal,
                ];
            }

            // Periksa apakah ada data reviewer kedua
            if ($reviewer_dua) {
                $data_reviewer_dua = [
                    'reviewer_dua' => $reviewer_dua->p_reviewProposal->reviewer_dua_dosen->r_dosen->nama_dosen,
                    'pembimbing_dua' => $reviewer_dua->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
                    'status_dua' => $reviewer_dua->status_review_proposal,
                    'status_final_proposal' => $reviewer_dua->p_reviewProposal->status_final_proposal,
                ];
            }

            // Gabungkan data jika ada kedua reviewer
            $merged_data[] = [
                'penugasan_id' => $penugasan_id,
                'proposal_ta_id_satu' => $reviewer_satu ? $reviewer_satu->p_reviewProposal->proposal_ta->id_proposal_ta : null,
                'proposal_ta_id_dua' => $reviewer_dua ? $reviewer_dua->p_reviewProposal->proposal_ta->id_proposal_ta : null,
                'nama_mahasiswa' => $reviewer_satu ? $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nama : null,
                'nim_mahasiswa' => $reviewer_satu ? $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nim : null,
                'judul' => $reviewer_satu ? $reviewer_satu->p_reviewProposal->proposal_ta->judul : null,
                'reviewer_satu' => $data_reviewer_satu ? $data_reviewer_satu['reviewer_satu'] : null,
                'pembimbing_satu' => $data_reviewer_satu ? $data_reviewer_satu['pembimbing_satu'] : null,
                'reviewer_dua' => $data_reviewer_dua ? $data_reviewer_dua['reviewer_dua'] : null,
                'pembimbing_dua' => $data_reviewer_dua ? $data_reviewer_dua['pembimbing_dua'] : null,
                'status_satu' => $data_reviewer_satu ? $data_reviewer_satu['status_satu'] : null,
                'status_dua' => $data_reviewer_dua ? $data_reviewer_dua['status_dua'] : null,
                'status_final_proposal' => $data_reviewer_dua ? $data_reviewer_dua['status_final_proposal'] : null,
            ];
        }

        debug($merged_data);

        return view('admin.content.pimpinanProdi.hasil_review_proposal_ta', compact('merged_data', 'data_review_proposal_ta', 'data_ta'));
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
            $detailProposalTa = ReviewProposalTaDetailPivot::where('penugasan_id', $id)->get();
            if ($detailProposalTa->count() < 2) {
                Session::flash('error', 'Proposal belum di review');
                return redirect()->route('hasil_review_proposal_ta');
            }

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            $data = [
                'id_penugasan' => $request->id_penugasan,
                'status_final_proposal' => $request->status,
            ];
            //dd($request->all());
            $ReviewProposalTAModel = ReviewProposalTAModel::find($id);

            if ($ReviewProposalTAModel) {
                $ReviewProposalTAModel->update($data);
            }
            return redirect()->route('hasil_review_proposal_ta')->with('success', 'Data berhasil diperbarui.');
        }
    }

    public function export_excel()
    {
        $kaprodi = $this->getDosen();
        // Ambil semua data review proposal
        $data_review_proposal_ta = ReviewProposalTAModel::orderByDesc('id_penugasan')
            ->where('pimpinan_prodi_id', $kaprodi->id_pimpinan_prodi)
            ->where('status_final_proposal', '=', '3')
            ->get();
        //dd($data_review_proposal_ta);
        // Cek apakah ada data dengan status_final_proposal = 1
        if ($data_review_proposal_ta->isNotEmpty()) {
            // Jika ada data final, unduh file Excel
            return Excel::download(new ExportHasil_final_proposal($data_review_proposal_ta), "hasil_final_proposal.xlsx");
        } else {
            // Jika tidak ada data final, redirect dengan pesan kesalahan
            return redirect()->route('hasil_review_proposal_ta')->with('error', 'Data final/diterima belum ada.');
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
