<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rep_RPS;
use App\Models\Ver_RPS;
use App\Models\Rep_UAS;
use App\Models\Ver_UAS;

class KajurController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function RepProposalTAJurusan()
    {
        $data_rep_proposal_jurusan = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('dosen as reviewer_satu', 'review_proposal_ta.reviewer_satu', '=', 'reviewer_satu.id_dosen')
            ->join('dosen as reviewer_dua', 'review_proposal_ta.reviewer_dua', '=', 'reviewer_dua.id_dosen')
            ->join('dosen as pembimbing_satu', 'proposal_ta.pembimbing_satu', '=', 'pembimbing_satu.id_dosen')
            ->join('dosen as pembimbing_dua', 'proposal_ta.pembimbing_dua', '=', 'pembimbing_dua.id_dosen')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('review_proposal_ta.*', 'proposal_ta.*', 'jurusan.*', 'prodi.*', 'mahasiswa.*', 'reviewer_satu.nama_dosen as reviewer_satu_nama', 'reviewer_dua.nama_dosen as reviewer_dua_nama', 'pembimbing_satu.nama_dosen as pembimbing_satu_nama', 'pembimbing_dua.nama_dosen as pembimbing_dua_nama')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        debug($data_rep_proposal_jurusan);
        return view('admin.content.info_proposal_ta_jurusan', compact('data_rep_proposal_jurusan'));
    }

    public function grafik_rps()
    {
        $banyak_pengunggahan = Rep_RPS::join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps.id_rep_rps) as banyak_pengunggahan"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = Ver_RPS::join('rep_rps', 'ver_rps.rep_rps_id', '=', 'rep_rps.id_rep_rps')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps.id_ver_rps) as banyak_verifikasi"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $semester = Rep_RPS::join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $data_ver_rps = DB::table('ver_rps')
            ->join('rep_rps', 'ver_rps.rep_rps_id', '=', 'rep_rps.id_rep_rps')
            ->join('dosen', 'rep_rps.dosen_id', '=', 'dosen.id_dosen')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_rps.*', 'rep_rps.*', 'dosen.nama_dosen', 'matkul.nama_matkul', 'smt_thnakd.smt_thnakd')
            ->get();

        return view('admin.content.GrafikRPS', compact('banyak_pengunggahan', 'banyak_verifikasi', 'semester', 'data_ver_rps'));
    }

    public function grafik_uas()
    {
        $banyak_pengunggahan = Rep_UAS::join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_uas.id_rep_uas) as banyak_pengunggahan"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi = Ver_UAS::join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
            ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_uas.id_ver_uas) as banyak_verifikasi"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $semester = Rep_uas::join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd as semester"))
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('semester');

        $data_ver_uas = DB::table('ver_uas')
            ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
            ->join('dosen', 'rep_uas.dosen_id', '=', 'dosen.id_dosen')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_uas.*', 'rep_uas.*', 'dosen.nama_dosen', 'matkul.nama_matkul', 'smt_thnakd.smt_thnakd')
            ->get();

        return view('admin.content.GrafikUAS', compact('banyak_pengunggahan', 'banyak_verifikasi', 'semester', 'data_ver_uas'));
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

        $data = DB::table('review_proposal_ta')
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

        $data_proposal = DB::table('review_proposal_ta')
            ->join('proposal_ta', 'review_proposal_ta.proposal_ta_id', '=', 'proposal_ta.id_proposal_ta')
            ->join('mahasiswa', 'proposal_ta.mahasiswa_id', '=', 'mahasiswa.id_mahasiswa')
            ->select('review_proposal_ta.*', 'proposal_ta.*', 'mahasiswa.*')
            ->get();

        return view('admin.content.GrafikProposal', compact('review', 'statuses', 'bulan', 'data_proposal'));
    }

    public function index()
    {
        //
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
