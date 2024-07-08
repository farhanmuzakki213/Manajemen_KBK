<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use App\Models\ThnAkademik;
use Illuminate\Http\Request;
use App\Models\PimpinanProdi;
use App\Models\ProposalTAModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ReviewProposalTAModel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Validator;
use App\Models\ReviewProposalTaDetailPivot;

class kaprodiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:pimpinanProdi-dashboard', ['only' => ['dashboard_kaprodi', 'getDosen']]);
        $this->middleware('permission:pimpinanProdi-view grafikRps', ['only' => ['grafik_rps', 'getDosen']]);
        $this->middleware('permission:pimpinanProdi-view grafikUas', ['only' => ['grafik_uas', 'getDosen']]);
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
        //
    }

    public function dashboard_kaprodi()
    {
        $kaprodi = $this->getDosen();
        $data_rps = $this->data_rps();
        $data_uas = $this->data_uas();
        debug($data_rps, $data_uas);
        $total_jumlah_proposal = 0;
        $total_jumlah_review_proposal = 0;

        // Count Thesis Proposal data for this Prodi
        $jumlah_proposal = ReviewProposalTAModel::whereHas('proposal_ta.r_mahasiswa', function ($query) use ($kaprodi) {
            $query->where('prodi_id', $kaprodi->prodi_id);
        })->count();

        $total_jumlah_proposal += $jumlah_proposal * 2;

        // Count Thesis Proposal Review data for this Prodi
        $jumlah_review_proposal = ReviewProposalTaDetailPivot::whereHas('p_reviewProposal.proposal_ta.r_mahasiswa', function ($query) use ($kaprodi) {
            $query->where('prodi_id', $kaprodi->prodi_id);
        })->count();

        $total_jumlah_review_proposal += $jumlah_review_proposal;

        $total_ta = $total_jumlah_proposal + $total_jumlah_review_proposal;

        $percentProposalTA = $total_ta > 0 ? ($total_jumlah_proposal / $total_ta) * 100 : 0;
        $percentReviewProposalTA = $total_ta > 0 ? ($total_jumlah_review_proposal / $total_ta) * 100 : 0;

        debug($jumlah_proposal);
        debug($total_jumlah_proposal);
        debug($jumlah_review_proposal);
        debug($total_jumlah_review_proposal);
        debug($total_ta);
        debug($percentProposalTA);
        debug($percentReviewProposalTA);
        /* $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

        // Hitung jumlah unggahan dan verifikasi RPS
        $queryRPS = RepRpsUas::where('type', '=', '0')
            ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })->with('r_dosen_matkul.p_kelas.r_prodi')->get();

        $banyak_pengunggahan_rps = $queryRPS->count();
        $banyak_verifikasi_rps = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kaprodi, $queryRPS) {
            $query->where('type', '=', '0')
                ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kaprodi) {
                    $query->where('prodi_id', $kaprodi->prodi_id);
                })
                ->whereIn('id_rep_rps_uas', $queryRPS->pluck('id_rep_rps_uas')->all());
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->count();

        // Hitung jumlah unggahan dan verifikasi UAS
        $queryUAS = RepRpsUas::where('type', '=', '1')
            ->whereHas('r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })->with('r_dosen_matkul.p_kelas.r_prodi')->get();

        $banyak_pengunggahan_uas = $queryUAS->count();
        $banyak_verifikasi_uas = VerRpsUas::whereHas('r_rep_rps_uas', function ($query) use ($kaprodi, $queryUAS) {
            $query->where('type', '=', '1')
                ->whereHas('r_dosen_matkul.p_kelas.r_prodi', function ($query) use ($kaprodi) {
                    $query->where('prodi_id', $kaprodi->prodi_id);
                })
                ->whereIn('id_rep_rps_uas', $queryUAS->pluck('id_rep_rps_uas')->all());
        })
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) use ($smt_thnakd_saat_ini) {
                $query->where('id_smt_thnakd', $smt_thnakd_saat_ini->id_smt_thnakd);
            })
            ->count(); */

        // Hitung total 
        /* $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
        $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
        $total_ta = $jumlah_proposal + $jumlah_review_proposal; */

        // Hitung persentase 
        /* $percentUploadedRPS = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
        $percentVerifiedRPS = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;
        $percentUploadedUAS = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
        $percentVerifiedUAS = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;
        $percentProposalTA = $total_ta > 0 ? ($jumlah_proposal / $total_ta) * 100 : 0;
        $percentReviewProposalTA = $total_ta > 0 ? ($jumlah_review_proposal / $total_ta) * 100 : 0; */
        // $percentVerifiedRPS = $banyak_pengunggahan_rps > 0 ? ($banyak_verifikasi_rps / $banyak_pengunggahan_rps) * 100 : 0;
        // $percentUploadedRPS = 100 - $percentVerifiedRPS;
        // $percentVerifiedUAS = $banyak_pengunggahan_uas > 0 ? ($banyak_verifikasi_uas / $banyak_pengunggahan_uas) * 100 : 0;
        // $percentUploadedUAS = 100 - $percentVerifiedUAS;
        // $percentReviewProposalTA = $jumlah_proposal > 0 ? ($jumlah_review_proposal / $jumlah_proposal) * 100 : 0;
        // $percentProposalTA = 100 - $percentReviewProposalTA;

        // debug($percentVerifiedRPS);
        // debug($percentUploadedRPS);
        // debug($percentVerifiedUAS);
        // debug($percentUploadedUAS);
        // debug($percentProposalTA);
        // debug($percentReviewProposalTA);

        // debug($queryRPS->toArray());
        // debug($queryUAS->toArray());

        return view('admin.content.PimpinanProdi.dashboard_kaprodi', compact(
            'data_uas',
            'data_rps',
            'jumlah_proposal',
            'total_jumlah_proposal',
            'jumlah_review_proposal',
            'total_jumlah_review_proposal'
        ));
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

    public function data_rps()
    {
        $kaprodi = $this->getDosen();
        $banyak_pengunggahan_smt = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_smt = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');


        $banyak_berita_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $banyak_berita_ver_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $banyak_pengunggahan_kbk = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_pengunggahan', 'jenis_kbk.jenis_kbk');

        $banyak_verifikasi_kbk = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_verifikasi', 'jenis_kbk.jenis_kbk');


        $banyak_berita_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $banyak_berita_ver_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $kbk = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk as kbk"))
            ->where('rep_rps_uas.type', '=', '0')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('kbk');

        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas', function ($query) use ($kaprodi) {
                $query->where('type', '=', '0')
                    ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kaprodi) {
                        $query->where('prodi_id', '=', $kaprodi->prodi_id);
                    });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
        $data = [
            'banyak_pengunggahan_smt' => $banyak_pengunggahan_smt,
            'banyak_verifikasi_smt' => $banyak_verifikasi_smt,
            'banyak_berita_smt' => $banyak_berita_smt,
            'banyak_berita_ver_smt' => $banyak_berita_ver_smt,
            'semester' => $semester,
            'banyak_pengunggahan_kbk' => $banyak_pengunggahan_kbk,
            'banyak_verifikasi_kbk' => $banyak_verifikasi_kbk,
            'banyak_berita_kbk' => $banyak_berita_kbk,
            'banyak_berita_ver_kbk' => $banyak_berita_ver_kbk,
            'kbk' => $kbk,
            'data_ver_rps' => $data_ver_rps,
        ];
        return $data;
    }

    public function grafik_rps()
    {
        $data = $this->data_rps();

        return view('admin.content.pimpinanProdi.GrafikRpsProdi', compact('data'));
    }


    public function data_uas()
    {
        $kaprodi = $this->getDosen();
        $banyak_pengunggahan_smt = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_smt = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');


        $banyak_berita_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $banyak_berita_ver_smt = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $banyak_pengunggahan_kbk = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_pengunggahan', 'jenis_kbk.jenis_kbk');

        $banyak_verifikasi_kbk = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_verifikasi', 'jenis_kbk.jenis_kbk');


        $banyak_berita_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(DISTINCT ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $banyak_berita_ver_kbk = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('banyak_berita', 'jenis_kbk.jenis_kbk');

        $kbk = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('matkul_kbk', 'rep_rps_uas.matkul_kbk_id', '=', 'matkul_kbk.id_matkul_kbk')
            ->join('matkul', 'matkul_kbk.matkul_id', '=', 'matkul.id_matkul')
            ->join('kurikulum', 'matkul.kurikulum_id', '=', 'kurikulum.id_kurikulum')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id_prodi')
            ->join('jenis_kbk', 'matkul_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->select(DB::raw("jenis_kbk.jenis_kbk as kbk"))
            ->where('rep_rps_uas.type', '=', '1')
            ->where('prodi.id_prodi', '=', $kaprodi->prodi_id)
            ->groupBy('jenis_kbk.jenis_kbk')
            ->pluck('kbk');

        $data_ver_rps = VerRpsUas::with('r_pengurus.r_dosen', 'r_rep_rps_uas')
            ->whereHas('r_rep_rps_uas', function ($query) use ($kaprodi) {
                $query->where('type', '=', '1')
                    ->whereHas('r_matkulKbk.r_matkul.r_kurikulum.r_prodi', function ($query) use ($kaprodi) {
                        $query->where('prodi_id', '=', $kaprodi->prodi_id);
                    });
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();

        $data = [
            'banyak_pengunggahan_smt' => $banyak_pengunggahan_smt,
            'banyak_verifikasi_smt' => $banyak_verifikasi_smt,
            'banyak_berita_smt' => $banyak_berita_smt,
            'banyak_berita_ver_smt' => $banyak_berita_ver_smt,
            'semester' => $semester,
            'banyak_pengunggahan_kbk' => $banyak_pengunggahan_kbk,
            'banyak_verifikasi_kbk' => $banyak_verifikasi_kbk,
            'banyak_berita_kbk' => $banyak_berita_kbk,
            'banyak_berita_ver_kbk' => $banyak_berita_ver_kbk,
            'kbk' => $kbk,
            'data_ver_rps' => $data_ver_rps,
        ];
        return $data;
    }

    public function grafik_uas()
    {
        $data = $this->data_uas();
        return view('admin.content.pimpinanProdi.GrafikUasProdi', compact('data'));
    }
}
