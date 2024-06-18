<?php

namespace App\Http\Controllers\PimpinanJurusan;

use App\Http\Controllers\Controller;
use App\Models\RepRpsUas;
use App\Models\ReviewProposalTaDetailPivot;
use App\Models\ReviewProposalTAModel;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KajurController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function RepProposalTAJurusan()
    {
        $data_rep_proposal_jurusan = ReviewProposalTAModel:: with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('id_penugasan')
            ->get();

        debug($data_rep_proposal_jurusan);
        return view('admin.content.pimpinanJurusan.rep_proposal_ta_jurusan', compact('data_rep_proposal_jurusan'));
    }

    public function grafik_rps()
    {
        $banyak_pengunggahan = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $data_ver_rps = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '0'); 
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
            debug($data_ver_rps);
        return view('admin.content.pimpinanJurusan.GrafikRPS', compact('banyak_pengunggahan', 'banyak_verifikasi', 'semester', 'data_ver_rps'));
    }


    public function grafik_uas()
    {
        $banyak_pengunggahan = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $data_ver_uas = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '1'); 
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        return view('admin.content.pimpinanJurusan.GrafikUAS', compact('banyak_pengunggahan', 'banyak_verifikasi', 'semester', 'data_ver_uas'));
    }

    public function grafik_proposal()
    {
        $statuses = ['Diajukan', 'Ditolak', 'Direvisi', 'Diterima'];
        $status_mapping = [
            0 => 'Diajukan',
            1 => 'Ditolak',
            2 => 'Direvisi',
            3 => 'Diterima'
        ];

        $data = DB::table('review_proposal_ta_detail_pivot')
            ->join('review_proposal_ta', 'review_proposal_ta_detail_pivot.penugasan_id', '=', 'review_proposal_ta.id_penugasan')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTHNAME(tanggal_review) as month"),
                'proposal_ta.status_proposal_ta'
            )
            ->groupBy(DB::raw("MONTHNAME(tanggal_review)"), 'proposal_ta.status_proposal_ta')
            ->orderBy(DB::raw("MONTH(tanggal_review)"))
            ->get();

        $review = [];
        $bulan = [];

        foreach ($data as $value) {
            $month = $value->month;
            $status = $status_mapping[$value->status_proposal_ta];

            if (!isset($review[$month])) {
                $review[$month] = array_fill_keys($statuses, 0);
                $bulan[] = $month;
            }
            $review[$month][$status] = $value->count;
        }

        // Ensure all months have all statuses even if they are zero
        foreach ($bulan as $month) {
            foreach ($statuses as $status) {
                if (!isset($review[$month][$status])) {
                    $review[$month][$status] = 0;
                }
            }
        }

        $review = array_values($review);

        $data_proposal = ReviewProposalTaDetailPivot::with('p_reviewProposal')
            ->get();

        return view('admin.content.pimpinanJurusan.GrafikProposal', compact('review', 'statuses', 'bulan', 'data_proposal'));
    }


    public function RepRPSJurusan()
    {
        $data_rep_rps = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
        ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
            $query->where('status_smt_thnakd', '=', '1'); 
        })
        ->whereHas('r_rep_rps_uas', function ($query) {
            $query->where('type', '=', '0'); 
        })
        ->orderByDesc('id_ver_rps_uas')
            ->get();
            //dd($data_rep_rps);
        return view('admin.content.pimpinanJurusan.rep_RPS_jurusan', compact('data_rep_rps'));
    }

    public function RepSoalUASJurusan()
    {
        $data_rep_soal_uas = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
        ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
            $query->where('status_smt_thnakd', '=', '1'); 
        })
        ->whereHas('r_rep_rps_uas', function ($query) {
            $query->where('type', '=', '1'); 
        })
        ->orderByDesc('id_ver_rps_uas')
        ->get();
        debug($data_rep_soal_uas);
        return view('admin.content.pimpinanJurusan.rep_Soal_UAS_jurusan', compact('data_rep_soal_uas'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
