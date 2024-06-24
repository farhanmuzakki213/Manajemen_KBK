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
        $smt_thnakd_saat_ini = ThnAkademik::where('status_smt_thnakd', '1')->first();

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
            ->count();





        // Ambil data proposal TA dengan mahasiswa terkait prodi
        $data_proposal_ta = ProposalTAModel::with('r_mahasiswa.r_prodi')
            ->whereHas('r_mahasiswa.r_prodi', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })
            ->orderBy('proposal_ta.id_proposal_ta', 'desc')
            ->get();

        // Debugging untuk memeriksa data proposal TA
        debug($data_proposal_ta->toArray());
        $jumlah_proposal = $data_proposal_ta->count();
        
        // Ambil data review proposal TA dengan filter berdasarkan prodi
        $data_review_proposal_ta = ReviewProposalTaDetailPivot::with('p_reviewProposal', 'p_reviewProposal.proposal_ta.r_mahasiswa.r_prodi')
            ->whereHas('p_reviewProposal.proposal_ta.r_mahasiswa.r_prodi', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })
            ->orderBy('review_proposal_ta_detail_pivot.penugasan_id', 'desc')
            ->get();
            $jumlah_review_proposal = $data_review_proposal_ta->count();
        // Debugging untuk memeriksa data review proposal TA
        debug($data_review_proposal_ta->toArray());

        // Kelompokkan data review berdasarkan penugasan_id
        $grouped_data = $data_review_proposal_ta->groupBy('penugasan_id');

        // Ambil dua penugasan_id pertama
        $two_penugasan_ids = $grouped_data->keys()->take(2);

        // Inisialisasi array untuk menyimpan data yang sudah digabungkan
        $merged_data = [];

        // foreach ($two_penugasan_ids as $penugasan_id) {
        //     // Ambil data dari kelompok dengan penugasan_id tertentu
        //     $group = $grouped_data[$penugasan_id];

        //     // Ambil data reviewer pertama dan kedua dari kelompok
        //     $reviewer_satu = $group->where('dosen', '1')->first();
        //     $reviewer_dua = $group->where('dosen', '2')->first();

            // Jika ada data reviewer pertama dan kedua, gabungkan dalam satu array
        //     if ($reviewer_satu && $reviewer_dua) {
        //         $merged_data[] = [
        //             'penugasan_id' => $penugasan_id,
        //             'nama_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nama,
        //             'nim_mahasiswa' => $reviewer_satu->p_reviewProposal->proposal_ta->r_mahasiswa->nim,
        //             'judul' => $reviewer_satu->p_reviewProposal->proposal_ta->judul,
        //             'reviewer_satu' => $reviewer_satu->p_reviewProposal->reviewer_satu_dosen->r_dosen->nama_dosen,
        //             'pembimbing_satu' => $reviewer_satu->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
        //             'reviewer_dua' => $reviewer_dua->p_reviewProposal->reviewer_dua_dosen->r_dosen->nama_dosen,
        //             'pembimbing_dua' => $reviewer_dua->p_reviewProposal->proposal_ta->r_pembimbing_satu->nama_dosen,
        //             'status_satu' => $reviewer_satu->status_review_proposal,
        //             'status_dua' => $reviewer_dua->status_review_proposal,
        //             'status_final_proposal' => $reviewer_dua->p_reviewProposal->status_final_proposal,
        //         ];
        //     }
        // }

        // debug($merged_data);

        // Hitung total 
        $total_rps = $banyak_pengunggahan_rps + $banyak_verifikasi_rps;
        $total_uas = $banyak_pengunggahan_uas + $banyak_verifikasi_uas;
        $total_ta = $jumlah_proposal + $jumlah_review_proposal;

        // Hitung persentase 
        $percentUploadedRPS = $total_rps > 0 ? ($banyak_pengunggahan_rps / $total_rps) * 100 : 0;
        $percentVerifiedRPS = $total_rps > 0 ? ($banyak_verifikasi_rps / $total_rps) * 100 : 0;
        $percentUploadedUAS = $total_uas > 0 ? ($banyak_pengunggahan_uas / $total_uas) * 100 : 0;
        $percentVerifiedUAS = $total_uas > 0 ? ($banyak_verifikasi_uas / $total_uas) * 100 : 0;
        $percentProposalTA = $total_ta > 0 ? ($jumlah_proposal / $total_ta) * 100 : 0;
        $percentReviewProposalTA = $total_ta > 0 ? ($jumlah_review_proposal / $total_ta) * 100 : 0;

        // debug($queryRPS->toArray());
        // debug($queryUAS->toArray());

        return view('admin.content.PimpinanProdi.dashboard_kaprodi', compact(
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