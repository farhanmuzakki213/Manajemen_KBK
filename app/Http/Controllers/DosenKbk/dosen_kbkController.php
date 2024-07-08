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

use function PHPUnit\Framework\isEmpty;

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
        $data_penugasan = ReviewProposalTAModel::with('reviewer_satu_dosen', 'reviewer_dua_dosen', 'review_proposal_ta_detail')
            ->where(function ($query) use ($dosenKbk) {
                $query->where('reviewer_satu', $dosenKbk->id_dosen_kbk)
                    ->orWhere('reviewer_dua', $dosenKbk->id_dosen_kbk);
            })
            ->orderBy('id_penugasan', 'desc')
            ->get();
        $jumlah_proposal = $data_penugasan->count();
        $data_penugasan = ReviewProposalTAModel::with('reviewer_satu_dosen', 'reviewer_dua_dosen', 'review_proposal_ta_detail')
            ->orderBy('id_penugasan', 'desc')
            ->get();
        debug($data_penugasan->toArray());

        $dosen = [];

        foreach ($data_penugasan as $data) {
            $data_reviewer = [];
            if (
                $data->reviewer_satu == $dosenKbk->id_dosen_kbk &&
                $data->review_proposal_ta_detail()->where('dosen', '1')->exists()
            ) {

                $data_reviewer = [
                    'reviewer_id' => $data->reviewer_satu,
                    'dosen' => '1'
                ];
            }
            if (
                $data->reviewer_dua == $dosenKbk->id_dosen_kbk &&
                $data->review_proposal_ta_detail()->where('dosen', '2')->exists()
            ) {

                $data_reviewer = [
                    'reviewer_id' => $data->reviewer_dua,
                    'dosen' => '2'
                ];
            }
            if (!empty($data_reviewer)) {
                $dosen[] = $data_reviewer;
            }
        }

        debug($dosen);

        $jumlah_review_proposal = count($dosen);

        $percentReviewProposalTA = $jumlah_proposal > 0 ? ($jumlah_review_proposal / $jumlah_proposal) * 100 : 0;
        $percentProposalTA = 100 - $percentReviewProposalTA;
        //debug($jumlah_review_proposal);

        /* return $data; */
        return view('admin.content.dosenKbk.dashboard_dosenKbk', compact('jumlah_proposal', 'jumlah_review_proposal', 'percentReviewProposalTA', 'percentProposalTA'));
    }
}
