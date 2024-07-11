<?php

namespace App\Http\Controllers\PimpinanJurusan;

use App\Models\Prodi;
use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use App\Models\ThnAkademik;
use Illuminate\Http\Request;
use App\Models\PimpinanJurusan;
use App\Models\ProposalTAModel;
use Illuminate\Support\Facades\DB;
use App\Models\DosenPengampuMatkul;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewProposalTAModel;
use App\Models\DosenPengampuMatkulDetail;
use App\Models\ReviewProposalTaDetailPivot;


class KajurController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pimpinanJurusan-dashboard', ['only' => ['dashboard_pimpinan', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view RepProposalTAJurusan', ['only' => ['RepProposalTAJurusan', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view grafikRps', ['only' => ['grafik_rps', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view grafikUas', ['only' => ['grafikUas', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view grafikProposal', ['only' => ['grafik_proposal', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view RepRPSJurusan', ['only' => ['RepRPSJurusan', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-view RepSoalUASJurusan', ['only' => ['RepSoalUASJurusan', 'getDosen']]);
    }
    /**
     * Display a listing of the resource.
     */

    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $kajur = PimpinanJurusan::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $kajur;
    }



    public function dashboard_pimpinan(Request $request)
    {
        // Get current academic semester
        $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

        // Get current department head (Kajur) data
        $kajur = $this->getDosen();

        // Get all Prodi
        $prodi = Prodi::where('jurusan_id', 7)->get();

        // Initialize variables to store counts for selected Prodi
        $total_banyak_pengunggahan_rps = 0;
        $total_banyak_verifikasi_rps = 0;
        $total_banyak_pengunggahan_uas = 0;
        $total_banyak_verifikasi_uas = 0;
        $total_jumlah_proposal = 0;
        $total_jumlah_review_proposal = 0;

        // Get selected Prodi ID from request
        $prodi_id = $request->input('prodi_id');

        // Loop through each Prodi or filter by selected Prodi
        foreach ($prodi as $single_prodi) {
            if ($prodi_id && $prodi_id != $single_prodi->id_prodi) {
                continue; // Skip if Prodi is selected and doesn't match current iteration
            }

            // Count RPS uploads and verifications for this Prodi
            $queryRPS = RepRpsUas::where('type', '=', '0')
                ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                    $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
                })
                ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($single_prodi) {
                    $query->where('prodi_id', $single_prodi->id_prodi);
                });

            $banyak_pengunggahan_rps = $queryRPS->count();
            $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kajur, $queryRPS) {
                $query->whereIn('id_rep_rps_uas', $queryRPS->pluck('id_rep_rps_uas')->all());
            })->count();

            $total_banyak_pengunggahan_rps += $banyak_pengunggahan_rps;
            $total_banyak_verifikasi_rps += $banyak_verifikasi_rps;

            // Count UAS uploads and verifications for this Prodi
            $queryUAS = RepRpsUas::where('type', '=', '1')
                ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                    $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
                })
                ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($single_prodi) {
                    $query->where('prodi_id', $single_prodi->id_prodi);
                });

            $banyak_pengunggahan_uas = $queryUAS->count();
            $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kajur, $queryUAS) {
                $query->whereIn('id_rep_rps_uas', $queryUAS->pluck('id_rep_rps_uas')->all());
            })->count();

            $total_banyak_pengunggahan_uas += $banyak_pengunggahan_uas;
            $total_banyak_verifikasi_uas += $banyak_verifikasi_uas;

            // Count Thesis Proposal data for this Prodi
            $jumlah_proposal = ReviewProposalTAModel::whereHas('proposal_ta.r_mahasiswa', function ($query) use ($single_prodi) {
                $query->where('prodi_id', $single_prodi->id_prodi);
            })->count();

            $total_jumlah_proposal += $jumlah_proposal * 2;

            // Count Thesis Proposal Review data for this Prodi
            $jumlah_review_proposal = ReviewProposalTaDetailPivot::whereHas('p_reviewProposal.proposal_ta.r_mahasiswa', function ($query) use ($single_prodi) {
                $query->where('prodi_id', $single_prodi->id_prodi);
            })->count();

            $total_jumlah_review_proposal += $jumlah_review_proposal;

            if ($prodi_id) {
                break; // Stop the loop if specific Prodi is selected to prevent unnecessary iterations
            }
        }

        // Calculate totals
        $total_rps = $total_banyak_pengunggahan_rps + $total_banyak_verifikasi_rps;
        $total_uas = $total_banyak_pengunggahan_uas + $total_banyak_verifikasi_uas;
        $total_ta = $total_jumlah_proposal + $total_jumlah_review_proposal;

        // Calculate percentages
        $percentUploadedRPS = $total_rps > 0 ? ($total_banyak_pengunggahan_rps / $total_rps) * 100 : 0;
        $percentVerifiedRPS = $total_rps > 0 ? ($total_banyak_verifikasi_rps / $total_rps) * 100 : 0;
        $percentUploadedUAS = $total_uas > 0 ? ($total_banyak_pengunggahan_uas / $total_uas) * 100 : 0;
        $percentVerifiedUAS = $total_uas > 0 ? ($total_banyak_verifikasi_uas / $total_uas) * 100 : 0;
        $percentProposalTA = $total_ta > 0 ? ($total_jumlah_proposal / $total_ta) * 100 : 0;
        $percentReviewProposalTA = $total_ta > 0 ? ($total_jumlah_review_proposal / $total_ta) * 100 : 0;

        // $percentVerifiedRPS = $total_banyak_pengunggahan_rps > 0 ? ($total_banyak_verifikasi_rps / $total_banyak_pengunggahan_rps) * 100 : 0;
        // $percentUploadedRPS = 100 - $percentVerifiedRPS;
        // $percentVerifiedUAS = $total_banyak_pengunggahan_uas > 0 ? ($total_banyak_verifikasi_uas / $total_banyak_pengunggahan_uas) * 100 : 0;
        // $percentUploadedUAS = 100 - $percentVerifiedUAS;
        // $percentReviewProposalTA = $total_jumlah_proposal > 0 ? ($total_jumlah_review_proposal / $total_jumlah_proposal) * 100 : 0;
        // $percentProposalTA = 100 - $percentReviewProposalTA;
        debug($percentVerifiedUAS);
        debug($percentUploadedUAS);
        debug($percentVerifiedRPS);
        debug($percentUploadedRPS);
        debug($percentReviewProposalTA);
        debug($percentProposalTA);
        // Return view with data
        return view('admin.content.PimpinanJurusan.dashboard_pimpinan', compact(
            'percentUploadedRPS',
            'percentVerifiedRPS',
            'percentUploadedUAS',
            'percentVerifiedUAS',
            'percentProposalTA',
            'percentReviewProposalTA',
            'total_banyak_pengunggahan_rps',
            'total_banyak_verifikasi_rps',
            'total_banyak_pengunggahan_uas',
            'total_banyak_verifikasi_uas',
            'total_jumlah_proposal',
            'total_jumlah_review_proposal',
            'smt_thnakd_saat_ini', // Include current semester for filtering options in view
            'prodi' // Pass all Prodi to the view
        ));
    }








    // public function dashboard_pimpinan()
    // {
    //     // Get current academic semester
    //     $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

    //     // Get current department head (Kajur) data
    //     $kajur = $this->getDosen();

    //     $prodi = Prodi::all();

    //     // Count RPS uploads and verifications
    //     $queryRPS = RepRpsUas::where('type', '=', '0')
    //         ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
    //             $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
    //         })
    //         ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kajur) {
    //             $query->where('prodi_id', $kajur->prodi_id);
    //         });

    //     $banyak_pengunggahan_rps = $queryRPS->count();
    //     $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kajur, $queryRPS) {
    //         $query->whereIn('id_rep_rps_uas', $queryRPS->pluck('id_rep_rps_uas')->all());
    //     })->count();

    //     // Count UAS uploads and verifications
    //     $queryUAS = RepRpsUas::where('type', '=', '1')
    //         ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
    //             $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
    //         })
    //         ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kajur) {
    //             $query->where('prodi_id', $kajur->prodi_id);
    //         });

    //     $banyak_pengunggahan_uas = $queryUAS->count();
    //     $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kajur, $queryUAS) {
    //         $query->whereIn('id_rep_rps_uas', $queryUAS->pluck('id_rep_rps_uas')->all());
    //     })->count();

    //     // Fetch Thesis Proposal data
    //     $data_proposal_ta = ProposalTAModel::with('r_mahasiswa.r_prodi')
    //         ->whereHas('r_mahasiswa.r_prodi', function ($query) use ($kajur) {
    //             $query->where('prodi_id', $kajur->prodi_id);
    //         })
    //         ->orderBy('proposal_ta.id_proposal_ta', 'desc')
    //         ->get();

    //     $jumlah_proposal = $data_proposal_ta->count();

    //     // Fetch Thesis Proposal Review data
    //     $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal', 'p_reviewProposal.proposal_ta.r_mahasiswa.r_prodi')
    //         ->whereHas('p_reviewProposal.proposal_ta.r_mahasiswa.r_prodi', function ($query) use ($kajur) {
    //             $query->where('prodi_id', $kajur->prodi_id);
    //         })
    //         ->orderBy('review_proposal_ta_detail_pivot.penugasan_id', 'desc')
    //         ->get();

    //     $jumlah_review_proposal = $data_review_proposal_ta->count();

    //     // Calculate totals
    //     $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
    //     $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
    //     $total_ta = $jumlah_proposal + $jumlah_review_proposal;

    //     // Calculate percentages
    //     $percentUploadedRPS = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
    //     $percentVerifiedRPS = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;
    //     $percentUploadedUAS = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
    //     $percentVerifiedUAS = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;
    //     $percentProposalTA = $total_ta > 0 ? ($jumlah_proposal / $total_ta) * 100 : 0;
    //     $percentReviewProposalTA = $total_ta > 0 ? ($jumlah_review_proposal / $total_ta) * 100 : 0;

    //     // Return view with data
    //     return view('admin.content.PimpinanJurusan.dashboard_pimpinan', compact(
    //         'percentUploadedRPS',
    //         'percentVerifiedRPS',
    //         'percentUploadedUAS',
    //         'percentVerifiedUAS',
    //         'percentProposalTA',
    //         'percentReviewProposalTA',
    //         'banyak_pengunggahan_rps',
    //         'banyak_verifikasi_rps',
    //         'banyak_pengunggahan_uas',
    //         'banyak_verifikasi_uas',
    //         'jumlah_proposal',
    //         'jumlah_review_proposal',
    //         'smt_thnakd_saat_ini' // Include current semester for filtering options in view
    //     ));
    // }


    public function RepProposalTAJurusan()
    {
        $data_rep_proposal_jurusan = ReviewProposalTAModel::with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('id_penugasan')
            ->get();

        debug($data_rep_proposal_jurusan);
        return view('admin.content.pimpinanJurusan.rep_proposal_ta_jurusan', compact('data_rep_proposal_jurusan'));
    }



    public function grafik_rps()
    {
        $kajur = $this->getDosen();
        $banyak_pengunggahan_smt = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_smt = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $banyak_berita_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $banyak_berita_ver_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $banyak_pengunggahan_prodi = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_pengunggahan', 'prodi.prodi');

        $banyak_verifikasi_prodi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_verifikasi', 'prodi.prodi');

        $banyak_berita_prodi = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_berita', 'prodi.prodi');

        $banyak_berita_ver_prodi = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_berita', 'prodi.prodi');

        $prodi = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi as prodi"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('prodi.prodi')
            ->pluck('prodi');

        $banyak_pengunggahan_kbk = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_pengunggahan', 'jenis_kbk.jenis_kbk');

        $banyak_verifikasi_kbk = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_verifikasi', 'jenis_kbk.jenis_kbk');

        $banyak_berita_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $banyak_berita_ver_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $kbk = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk as jenis_kbk"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('jenis_kbk');

        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '0');
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        $data = [
            'banyak_pengunggahan_smt' => $banyak_pengunggahan_smt,
            'banyak_verifikasi_smt' => $banyak_verifikasi_smt,
            'banyak_berita_smt' => $banyak_berita_smt,
            'banyak_berita_ver_smt' => $banyak_berita_ver_smt,
            'semester' => $semester,
            'banyak_pengunggahan_prodi' => $banyak_pengunggahan_prodi,
            'banyak_verifikasi_prodi' => $banyak_verifikasi_prodi,
            'banyak_berita_prodi' => $banyak_berita_prodi,
            'banyak_berita_ver_prodi' => $banyak_berita_ver_prodi,
            'prodi' => $prodi,
            'banyak_pengunggahan_kbk' => $banyak_pengunggahan_kbk,
            'banyak_verifikasi_kbk' => $banyak_verifikasi_kbk,
            'banyak_berita_kbk' => $banyak_berita_kbk,
            'banyak_berita_ver_kbk' => $banyak_berita_ver_kbk,
            'kbk' => $kbk,
            'data_ver_rps' => $data_ver_rps,
        ];

        return view('admin.content.pimpinanJurusan.GrafikRPS', compact('data'));
    }


    public function grafik_uas()
    {
        $kajur = $this->getDosen();
        $banyak_pengunggahan_smt = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_smt = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $banyak_berita_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $banyak_berita_ver_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $banyak_pengunggahan_prodi = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_pengunggahan', 'prodi.prodi');

        $banyak_verifikasi_prodi = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_verifikasi', 'prodi.prodi');

        $banyak_berita_prodi = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_berita', 'prodi.prodi');

        $banyak_berita_ver_prodi = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('prodi.prodi')
            ->pluck('banyak_berita', 'prodi.prodi');

        $prodi = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('kurikulum', 'matkul_kbk.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("prodi.prodi as prodi"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('prodi.prodi')
            ->pluck('prodi');

        $banyak_pengunggahan_kbk = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_pengunggahan', 'jenis_kbk.jenis_kbk');

        $banyak_verifikasi_kbk = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_verifikasi', 'jenis_kbk.jenis_kbk');

        $banyak_berita_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $banyak_berita_ver_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('pimpinan_jurusan', 'ver_berita_acara.kajur', '=', 'pimpinan_jurusan.id_pimpinan_jurusan')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('pimpinan_jurusan.jurusan_id', $kajur->jurusan_id)
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $kbk = RepRpsUas::join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk as jenis_kbk"))
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('jenis_kbk');

        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', '=', $kajur->jurusan_id);
            })
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '1');
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        $data = [
            'banyak_pengunggahan_smt' => $banyak_pengunggahan_smt,
            'banyak_verifikasi_smt' => $banyak_verifikasi_smt,
            'banyak_berita_smt' => $banyak_berita_smt,
            'banyak_berita_ver_smt' => $banyak_berita_ver_smt,
            'semester' => $semester,
            'banyak_pengunggahan_prodi' => $banyak_pengunggahan_prodi,
            'banyak_verifikasi_prodi' => $banyak_verifikasi_prodi,
            'banyak_berita_prodi' => $banyak_berita_prodi,
            'banyak_berita_ver_prodi' => $banyak_berita_ver_prodi,
            'prodi' => $prodi,
            'banyak_pengunggahan_kbk' => $banyak_pengunggahan_kbk,
            'banyak_verifikasi_kbk' => $banyak_verifikasi_kbk,
            'banyak_berita_kbk' => $banyak_berita_kbk,
            'banyak_berita_ver_kbk' => $banyak_berita_ver_kbk,
            'kbk' => $kbk,
            'data_ver_rps' => $data_ver_rps,
        ];

        return view('admin.content.pimpinanJurusan.GrafikUAS', compact('data'));
    }

    public function grafik_proposal()
    {
        $kajur = $this->getDosen();
        $statuses = ['Diajukan', 'Ditolak', 'Direvisi', 'Diterima'];
        $status_mapping = [
            0 => 'Diajukan',
            1 => 'Ditolak',
            2 => 'Direvisi',
            3 => 'Diterima'
        ];

        $data = DB::table('review_proposal_ta_detail_pivot')
            ->join('review_proposal_ta', 'review_proposal_ta_detail_pivot.penugasan_id', '=', 'review_proposal_ta.id_penugasan')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTHNAME(tanggal_review) as month"),
                'review_proposal_ta.status_final_proposal'
            )
            ->groupBy(DB::raw("MONTHNAME(tanggal_review)"), 'review_proposal_ta.status_final_proposal')
            ->orderBy(DB::raw("MONTH(tanggal_review)"))
            ->get();
        //dd($data);
        $review = [];
        $bulan = [];

        foreach ($data as $value) {
            $month = $value->month;
            $status = $status_mapping[$value->status_final_proposal];

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

        /* $statuses = ['Diajukan', 'Ditolak', 'Direvisi', 'Diterima'];
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
        dd($data);
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
        } */

        $review = array_values($review);

        $data_proposal = ReviewProposalTaDetailPivot::with('p_reviewProposal')
            ->get();

        return view('admin.content.pimpinanJurusan.GrafikProposal', compact('review', 'statuses', 'bulan', 'data_proposal'));
    }


    // public function RepRPSJurusan()
    // {
    //     $data_rep_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
    //         ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
    //             $query->where('status_smt_thnakd', '=', '1');
    //         })
    //         ->whereHas('r_rep_rps_uas', function ($query) {
    //             $query->where('type', '=', '0');
    //         })
    //         ->orderByDesc('id_ver_rps_uas')
    //         ->get();


    //         $data_rep_rps_detail = DosenPengampuMatkulDetail::with([
    //             'r_matkulKbk.r_matkul',
    //             'r_dosen_matkul.r_dosen',
    //             'r_kelas'
    //         ])
    //         ->orderByDesc('dosen_matkul_id')
    //         ->get();
    //     //dd($data_rep_rps);
    //     return view('admin.content.pimpinanJurusan.rep_RPS_jurusan', compact('data_rep_rps', 'data_rep_rps_detail'));
    // }



    //     public function RepRPSJurusan()
    // {
    //     $data_rep_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
    //         ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
    //             $query->where('status_smt_thnakd', '=', '1');
    //         })
    //         ->whereHas('r_rep_rps_uas', function ($query) {
    //             $query->where('type', '=', '0');
    //         })
    //         ->orderBy('id_ver_rps_uas')
    //         ->get();

    //     $data_rep_rps_detail = DosenPengampuMatkulDetail::with([
    //         'r_matkulKbk.r_matkul',
    //         'r_dosen_matkul.r_dosen',
    //         'r_matkulKbk.r_kurikulum.r_prodi',
    //         'r_kelas'
    //     ])
    //     ->orderBy('dosen_matkul_id')
    //     ->get();

    //     // Menggabungkan data dalam satu array atau koleksi
    //     $merged_data = [];

    //     // Ambil data dari VerRpsUas untuk yang sudah diupload dan diverifikasi
    //     foreach ($data_rep_rps as $item) {
    //         $dosen_upload = optional($item->r_dosen_matkul)->r_dosen ? $item->r_dosen_matkul->r_dosen->nama_dosen : '-';

    //         $merged_data[] = [
    //             'id' => $item->id_ver_rps_uas,
    //             'kode_matkul' => optional($item->r_rep_rps_uas->r_matkulKbk->r_matkul)->nama_matkul ?? '-',
    //             'semester' => optional($item->r_rep_rps_uas->r_matkulKbk->r_matkul)->semester ?? '-',
    //             'dosen_upload' =>  $dosen_upload,
    //             'prodi' => optional($item->r_rep_rps_uas->r_matkulKbk->r_kurikulum->r_prodi)->prodi ?? '-',
    //             'dosen_verifikasi' => optional($item->r_pengurus->r_dosen)->nama_dosen ?? '-',
    //             'status_verifikasi' => $item->status_verifikasi == 0 ? 'Tidak Diverifikasi' : 'Diverifikasi',
    //             'aksi' => 'Aksi dari Rep RPS' // Sesuaikan dengan aksi yang sesuai
    //         ];
    //     }

    //     // Ambil data dari DosenPengampuMatkulDetail untuk yang belum mengupload file
    //     foreach ($data_rep_rps_detail as $item) {
    //         if ($item->r_dosen_matkul && $item->r_dosen_matkul->r_dosen) {
    //             // Periksa apakah sudah ada data dengan id_ver_rps_uas yang sama dalam merged_data
    //             $already_added = collect($merged_data)->contains('id', $item->dosen_matkul_id);

    //             // Jika belum ada dalam merged_data, tambahkan data dari DosenPengampuMatkulDetail
    //             if (!$already_added) {
    //                 $merged_data[] = [
    //                     'id' => $item->dosen_matkul_id,
    //                     'kode_matkul' => optional($item->r_matkulKbk->r_matkul)->nama_matkul ?? '-',
    //                     'semester' => '-', // Tidak ada semester dalam model DosenPengampuMatkulDetail
    //                     'dosen_upload' => $item->r_dosen_matkul->r_dosen->nama_dosen,
    //                     'prodi' => optional($item->r_matkulKbk->r_kurikulum->r_prodi)->prodi ?? '-',
    //                     'dosen_verifikasi' => '-', // Kosongkan karena data dari DosenPengampuMatkulDetail belum tentu diverifikasi
    //                     'status_verifikasi' => 'Belum Upload', // Tambahkan status khusus untuk belum diupload
    //                     'aksi' => 'Aksi dari Dosen Pengampu' // Sesuaikan dengan aksi yang sesuai
    //                 ];
    //             }
    //         }
    //     }

    //     return view('admin.content.pimpinanJurusan.rep_RPS_jurusan', compact('merged_data'));
    // }   

    public function RepRPSJurusan()
    {
        $kajur = $this->getDosen();
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk'
        ])
            ->where(function ($query) use ($kajur) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($kajur) {
                    $subQuery->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($nestedQuery) use ($kajur) {
                        $nestedQuery->where('jurusan_id', $kajur->jurusan_id);
                    })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '0');
                });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
        debug($data_ver_rps->toArray());
        $data_matkul_kbk = DosenPengampuMatkul::with([
            'p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd', 'p_matkulKbk.r_matkul.r_kurikulum.r_prodi'
        ])
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('p_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', $kajur->jurusan_id);
            })
            ->orderByDesc('id_dosen_matkul')
            ->get();


        /* debug($data_matkul_kbk->toArray()); */
        $data_array = $data_matkul_kbk->flatMap(function ($item) use ($kajur) {
            return $item->p_matkulKbk->flatMap(function ($matkulKbk) use ($item, $kajur) {
                $prodi = $matkulKbk->r_matkul->r_kurikulum->r_prodi;
                if ($prodi->jurusan_id === $kajur->jurusan_id) {
                    return [[
                        'nama_dosen' => $item->r_dosen->nama_dosen,
                        'smt_thnakd' => $item->r_smt_thnakd->smt_thnakd,
                        'kode_matkul' => optional($matkulKbk->r_matkul)->kode_matkul,
                        'semester' => optional($matkulKbk->r_matkul)->semester,
                        'prodi' => optional(optional($matkulKbk->r_matkul)->r_kurikulum)->r_prodi->prodi,
                    ]];
                } else {
                    return [];
                }
            });
        })->toArray();



        debug($data_array);
        $data_rep_rps = RepRpsUas::with('r_dosen_matkul', 'r_dosen_matkul.r_dosen', 'r_matkulKbk.r_matkul.r_kurikulum.r_prodi', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', $kajur->jurusan_id);
            })
            ->where('type', '=', '0')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug($data_rep_rps->toArray());
        $data_array_formatted = collect($data_array)->map(function ($item) {
            return [
                'nama_dosen' => $item['nama_dosen'],
                'smt_thnakd' => $item['smt_thnakd'],
                'kode_matkul' => $item['kode_matkul'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
            ];
        });
        $data_array_gabungan = $data_array_formatted->map(function ($item) use ($data_rep_rps) {
            $matched_data = $data_rep_rps->first(function ($data_rep_rps_item) use ($item) {
                return $item['nama_dosen'] == optional($data_rep_rps_item->r_dosen_matkul)->r_dosen->nama_dosen
                    && $item['smt_thnakd'] == optional($data_rep_rps_item->r_smt_thnakd)->smt_thnakd
                    && $item['kode_matkul'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->kode_matkul
                    && $item['semester'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->semester
                    && $item['prodi'] == optional(optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->r_kurikulum)->r_prodi->prodi;
            });
            return [
                'nama_dosen' => $item['nama_dosen'],
                'kode_matkul' => $item['kode_matkul'],
                'smt_thnakd' => $item['smt_thnakd'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
                'id_rep_rps_uas' => $matched_data ? $matched_data->id_rep_rps_uas : null,
                'file' => $matched_data ? $matched_data->file : null,
            ];
        });
        $result = $data_array_gabungan->toArray();
        debug($result);

        return view('admin.content.pimpinanJurusan.rep_RPS_jurusan', compact('data_ver_rps', 'result'));
    }








    public function RepSoalUASJurusan()
    {
        $kajur = $this->getDosen();
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk'
        ])
            ->where(function ($query) use ($kajur) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($kajur) {
                    $subQuery->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($nestedQuery) use ($kajur) {
                        $nestedQuery->where('jurusan_id', $kajur->jurusan_id);
                    })
                        ->whereHas('r_smt_thnakd', function ($nestedQuery) {
                            $nestedQuery->where('status_smt_thnakd', '=', '1');
                        })
                        ->where('type', '=', '1');
                });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
        debug($data_ver_rps->toArray());
        $data_matkul_kbk = DosenPengampuMatkul::with([
            'p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd', 'p_matkulKbk.r_matkul.r_kurikulum.r_prodi'
        ])
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('p_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', $kajur->jurusan_id);
            })
            ->orderByDesc('id_dosen_matkul')
            ->get();


        /* debug($data_matkul_kbk->toArray()); */
        $data_array = $data_matkul_kbk->flatMap(function ($item) use ($kajur) {
            return $item->p_matkulKbk->flatMap(function ($matkulKbk) use ($item, $kajur) {
                $prodi = $matkulKbk->r_matkul->r_kurikulum->r_prodi;
                if ($prodi->jurusan_id === $kajur->jurusan_id) {
                    return [[
                        'nama_dosen' => $item->r_dosen->nama_dosen,
                        'smt_thnakd' => $item->r_smt_thnakd->smt_thnakd,
                        'kode_matkul' => optional($matkulKbk->r_matkul)->kode_matkul,
                        'semester' => optional($matkulKbk->r_matkul)->semester,
                        'prodi' => optional(optional($matkulKbk->r_matkul)->r_kurikulum)->r_prodi->prodi,
                    ]];
                } else {
                    return [];
                }
            });
        })->toArray();



        debug($data_array);
        $data_rep_rps = RepRpsUas::with('r_dosen_matkul', 'r_dosen_matkul.r_dosen', 'r_matkulKbk.r_matkul.r_kurikulum.r_prodi', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kajur) {
                $query->where('jurusan_id', $kajur->jurusan_id);
            })
            ->where('type', '=', '1')
            ->orderByDesc('id_rep_rps_uas')
            ->get();
        debug($data_rep_rps->toArray());
        $data_array_formatted = collect($data_array)->map(function ($item) {
            return [
                'nama_dosen' => $item['nama_dosen'],
                'smt_thnakd' => $item['smt_thnakd'],
                'kode_matkul' => $item['kode_matkul'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
            ];
        });
        $data_array_gabungan = $data_array_formatted->map(function ($item) use ($data_rep_rps) {
            $matched_data = $data_rep_rps->first(function ($data_rep_rps_item) use ($item) {
                return $item['nama_dosen'] == optional($data_rep_rps_item->r_dosen_matkul)->r_dosen->nama_dosen
                    && $item['smt_thnakd'] == optional($data_rep_rps_item->r_smt_thnakd)->smt_thnakd
                    && $item['kode_matkul'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->kode_matkul
                    && $item['semester'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->semester
                    && $item['prodi'] == optional(optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->r_kurikulum)->r_prodi->prodi;
            });
            return [
                'nama_dosen' => $item['nama_dosen'],
                'kode_matkul' => $item['kode_matkul'],
                'smt_thnakd' => $item['smt_thnakd'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
                'id_rep_rps_uas' => $matched_data ? $matched_data->id_rep_rps_uas : null,
                'file' => $matched_data ? $matched_data->file : null,
            ];
        });
        $result = $data_array_gabungan->toArray();
        debug($result);
        return view('admin.content.pimpinanJurusan.rep_Soal_UAS_jurusan', compact('data_ver_rps', 'result'));
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
