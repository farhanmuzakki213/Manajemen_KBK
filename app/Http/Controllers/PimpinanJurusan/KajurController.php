<?php

namespace App\Http\Controllers\PimpinanJurusan;

use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use App\Models\ThnAkademik;
use Illuminate\Http\Request;
use App\Models\PimpinanJurusan;
use App\Models\ProposalTAModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewProposalTAModel;
use App\Models\ReviewProposalTaDetailPivot;


class KajurController extends Controller
{
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
            $jumlah_proposal = ProposalTAModel::whereHas('r_mahasiswa', function ($query) use ($single_prodi) {
                $query->where('prodi_id', $single_prodi->id_prodi);
            })->count();

            $total_jumlah_proposal += $jumlah_proposal;

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

        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
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

        $data_ver_uas = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
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
        $data_rep_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
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
        $data_rep_soal_uas = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
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
