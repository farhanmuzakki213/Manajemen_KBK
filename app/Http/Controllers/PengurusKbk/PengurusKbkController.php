<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use App\Models\ThnAkademik;
use App\Models\ProposalTAModel;
use App\Http\Controllers\Controller;
use App\Models\Pengurus_kbk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ReviewProposalTaDetailPivot;

class PengurusKbkController extends Controller
{
    public function __construct() {
        $this->middleware('permission:pengurusKbk-dashboard', ['only' => ['dashboard_pengurus', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-view GrafikRps', ['only' => ['grafik_rps', 'getDosen']]);
        $this->middleware('permission:pengurusKbk-view GrafikUas', ['only' => ['grafik_uas', 'getDosen']]);
    }
    /**
     * Display a listing of the resource.
     */


    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $pengurus = Pengurus_kbk::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $pengurus;
    }

    public function dashboard_pengurus()
    {
        $pengurus = $this->getDosen();
        $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

        // Hitung jumlah unggahan dan verifikasi RPS
        $queryRPS = RepRpsUas::where('type', '=', '0')
            ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->whereHas('r_matkulKbk.r_jenis_kbk', function ($query) use ($pengurus) {
                $query->where('jenis_kbk_id', $pengurus->jenis_kbk_id);
            })->with('r_matkulKbk.r_jenis_kbk')->get();

        $banyak_pengunggahan_rps = $queryRPS->count();
        $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($pengurus, $queryRPS) {
            $query->where('type', '=', '0')
                ->whereHas('r_matkulKbk.r_jenis_kbk', function ($query) use ($pengurus) {
                    $query->where('jenis_kbk_id', $pengurus->jenis_kbk_id);
                })
                ->whereIn('id_rep_rps_uas', $queryRPS->pluck('id_rep_rps_uas')->all());
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->count();

        $queryUAS = RepRpsUas::where('type', '=', '1')
            ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->whereHas('r_matkulKbk.r_jenis_kbk', function ($query) use ($pengurus) {
                $query->where('jenis_kbk_id', $pengurus->jenis_kbk_id);
            })->with('r_matkulKbk.r_jenis_kbk')->get();

        $banyak_pengunggahan_uas = $queryUAS->count();
        $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($pengurus, $queryUAS) {
            $query->where('type', '=', '1')
                ->whereHas('r_matkulKbk.r_jenis_kbk', function ($query) use ($pengurus) {
                    $query->where('jenis_kbk_id', $pengurus->jenis_kbk_id);
                })
                ->whereIn('id_rep_rps_uas', $queryUAS->pluck('id_rep_rps_uas')->all());
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->count();

        $data_proposal_ta = ProposalTAModel::with('r_jenis_kbk')
            // ->whereHas('r_jenis_kbk', function ($query) use ($pengurus) {
            //     $query->where('jenis_kbk_id', $pengurus->jenis_kbk);
            // })
            ->orderBy('proposal_ta.id_proposal_ta', 'desc')
            ->get();

        debug($data_proposal_ta->toArray());
        $jumlah_proposal = $data_proposal_ta->count();

        $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal', 'p_reviewProposal.proposal_ta.r_jenis_kbk')
            ->whereHas('p_reviewProposal.proposal_ta.r_jenis_kbk', function ($query) use ($pengurus) {
                $query->where('jenis_kbk_id', $pengurus->jenis_kbk_id);
            })
            ->orderBy('review_proposal_ta_detail_pivot.penugasan_id', 'desc')
            ->get();
        $jumlah_review_proposal = $data_review_proposal_ta->count();
        debug($data_review_proposal_ta->toArray());

        $grouped_data = $data_review_proposal_ta->groupBy('penugasan_id');

        $two_penugasan_ids = $grouped_data->keys()->take(2);

        $merged_data = [];

        $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
        $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
        $total_ta = $jumlah_proposal + $jumlah_review_proposal;

        $percentUploadedRPS = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
        $percentVerifiedRPS = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;
        $percentUploadedUAS = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
        $percentVerifiedUAS = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;
        $percentProposalTA = $total_ta > 0 ? ($jumlah_proposal / $total_ta) * 100 : 0;
        $percentReviewProposalTA = $total_ta > 0 ? ($jumlah_review_proposal / $total_ta) * 100 : 0;

        // $percentVerifiedRPS = $banyak_pengunggahan_rps > 0 ? ($banyak_verifikasi_rps / $banyak_pengunggahan_rps) * 100 : 0;
        // $percentUploadedRPS = 100 - $percentVerifiedRPS;
        // $percentVerifiedUAS = $banyak_pengunggahan_uas > 0 ? ($banyak_verifikasi_uas / $banyak_pengunggahan_uas) * 100 : 0;
        // $percentUploadedUAS = 100 - $percentVerifiedUAS;
        // $percentReviewProposalTA = $jumlah_proposal > 0 ? ($jumlah_review_proposal / $jumlah_proposal) * 100 : 0;
        // $percentProposalTA = 100 - $percentReviewProposalTA;

        debug($percentVerifiedRPS);
        debug($percentUploadedRPS);
        debug($percentVerifiedUAS);
        debug($percentUploadedUAS);
        debug($percentProposalTA);
        debug($percentReviewProposalTA);

        return view('admin.content.PengurusKbk.dashboard_pengurus', compact(
            'percentUploadedRPS',
            'percentVerifiedRPS',
            'percentUploadedUAS',
            'percentVerifiedUAS',
            'percentProposalTA',
            'percentReviewProposalTA',
            'banyak_pengunggahan_rps',
            'banyak_verifikasi_rps',
            'banyak_pengunggahan_uas',
            'banyak_verifikasi_uas',
            'jumlah_proposal',
            'jumlah_review_proposal',
        ));
    }

    public function grafik_rps()
    {
        $pengurus = $this->getDosen();
        $banyak_pengunggahan = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('matkul_kbk.jenis_kbk_id', $pengurus->jenis_kbk_id)
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->where('rep_rps_uas.type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');


        $banyak_berita = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

            $banyak_berita_ver = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');



        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '0')
            ->where('matkul_kbk.jenis_kbk_id', $pengurus->jenis_kbk_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');
        //dd($semester);
        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_dosen_matkul.r_dosen')
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '0');
            })
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->orderByDesc('id_ver_rps_uas')
            ->get();
        debug($data_ver_rps);
        return view('admin.content.pengurusKbk.GrafikRpsPengurus', compact('banyak_pengunggahan', 'banyak_verifikasi', 'semester', 'data_ver_rps', 'banyak_berita', 'banyak_berita_ver'));
    }


    public function grafik_uas()
    {
        $pengurus = $this->getDosen();
        $banyak_pengunggahan = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('matkul_kbk.jenis_kbk_id', $pengurus->jenis_kbk_id)
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->where('rep_rps_uas.type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $banyak_berita = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

            $banyak_berita_ver = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '1')
            ->where('matkul_kbk.jenis_kbk_id', $pengurus->jenis_kbk_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        // dd($banyak_pengunggahan);

        $data_ver_uas = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_dosen_matkul.r_dosen')
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '1');
            })
            ->where('pengurus_id', $pengurus->id_pengurus)
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        return view('admin.content.pengurusKbk.GrafikUasPengurus', compact('banyak_pengunggahan', 'banyak_verifikasi', 'banyak_berita', 'banyak_berita_ver', 'semester', 'data_ver_uas'));
    }
}
