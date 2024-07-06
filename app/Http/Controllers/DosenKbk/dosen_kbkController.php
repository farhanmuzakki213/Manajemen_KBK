<?php

namespace App\Http\Controllers\DosenKbk;

use App\Models\ThnAkademik;
use App\Models\ProposalTAModel;
use App\Http\Controllers\Controller;
use App\Models\DosenKBK;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewProposalTaDetailPivot;
use App\Models\ReviewProposalTAModel;
use Illuminate\Support\Facades\DB;

class dosen_kbkController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:dosenKbk-dashboard', ['only' => ['getDosen', 'dashboard_dosenKbk']]);
    }
    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $dosenKbk = DosenKBK::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $dosenKbk;
    }

    public function dashboard_dosenKbk()
    {
        $dosenKbk = $this->getDosen();
        $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

        $data_penugasan = ReviewProposalTAModel::with('reviewer_satu_dosen', 'reviewer_dua_dosen')
            ->where(function ($query) use ($dosenKbk) {
                $query->where('reviewer_satu', $dosenKbk->id_dosen_kbk)
                    ->orWhere('reviewer_dua', $dosenKbk->id_dosen_kbk);
            })
            ->orderBy('id_penugasan', 'desc')
            ->get();

        $jumlah_proposal = $data_penugasan->count();

        // $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal.reviewer_satu_dosen', 'p_reviewProposal.reviewer_dua_dosen')
        //     ->whereHas('p_reviewProposal', function ($query) use ($dosenKbk) {
        //         $query->where('reviewer_satu', $dosenKbk->id_dosen_kbk)
        //             ->orWhere('reviewer_dua', $dosenKbk->id_dosen_kbk);
        //     })
        //     ->orderBy('penugasan_id', 'desc')
        //     ->get();

        $data_review_proposal_ta = DB::table('review_proposal_ta_detail_pivot')
            ->join('review_proposal_ta', 'review_proposal_ta.id_penugasan', '=', 'review_proposal_ta_detail_pivot.penugasan_id')
            ->select(DB::raw("review_proposal_ta_detail_pivot.penugasan_id"))
            ->where(function ($query) use ($dosenKbk) {
                $query->where('review_proposal_ta.reviewer_satu', '=', $dosenKbk->id_dosen_kbk)
                    ->orWhere('review_proposal_ta.reviewer_dua', '=', $dosenKbk->id_dosen_kbk);
            })
            ->orderBy('penugasan_id', 'desc')
            ->get();


        $jumlah_review_proposal = $data_review_proposal_ta->count();

        // $total_ta = $jumlah_proposal + $jumlah_review_proposal;

        $percentReviewProposalTA = $jumlah_proposal > 0 ? ($jumlah_review_proposal / $jumlah_proposal) * 100 : 0;
        $percentProposalTA = 100 - $percentReviewProposalTA;

        // $data = [
        //     'jumlah_proposal' => $jumlah_proposal,
        //     'jumlah_review_proposal' => $jumlah_review_proposal,
        //     // 'percentProposalTA' => $total_ta > 0 ? ($jumlah_proposal / $total_ta) * 100 : 0,
        //     // 'percentReviewProposalTA' => $total_ta > 0 ? ($jumlah_review_proposal / $total_ta) * 100 : 0,
        //     'percentReviewProposalTA' => $percentReviewProposalTA,
        //     'percentProposalTA' => $percentProposalTA,
        // ];
        // debug($data);
        debug($jumlah_review_proposal);

        /* return $data; */
        return view('admin.content.dosenKbk.dashboard_dosenKbk', compact('jumlah_proposal', 'jumlah_review_proposal', 'percentReviewProposalTA', 'percentProposalTA'));
    }
}
