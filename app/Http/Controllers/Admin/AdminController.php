<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use App\Models\ProposalTAModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ReviewProposalTAModel;
use App\Models\ReviewProposalTaDetailPivot;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin-view RepProposalTA', ['only' => ['index']]);
        $this->middleware('permission:admin-sinkronData RepProposalTA', ['only' => ['storeAPI', 'show', 'getCariNomor']]);
        $this->middleware('permission:admin-dashboard', ['only' => ['dashboard_admin']]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function example(){
        return view('admin.content.example');
    }

    public function RepProposalTA()
    {
        $data_rep_proposal = ProposalTAModel::with('r_mahasiswa', 'r_pembimbing_satu', 'r_pembimbing_dua', 'r_jenis_kbk')
            ->orderByDesc('id_proposal_ta')
            ->get();

        return view('admin.content.admin.rep_proposal_ta', compact('data_rep_proposal'));
    }

    public function storeAPI(Request $request)
    {
        DB::beginTransaction();
        try {
            $differences_api = json_decode($request->differences_api, true);
            $differences_db = json_decode($request->differences_db, true);
            //dd($differences_api, $differences_db);
            foreach ($differences_db as $data) {
                $data_proposalTA = ProposalTAModel::where('id_proposal_ta', $data['id_proposal_ta'])->first();
                //dd($data_kurikulum);
                if ($data_proposalTA) {
                    $data_proposalTA->delete();
                }
            }
            $file_default = 'none';
            $jenis_kbk_default = rand(1, 5);
            foreach ($differences_api as $data) {
                $nextNumber = $this->getCariNomor();
                $data_mahasiswa = Mahasiswa::where('nim', $data['nim'])->pluck('id_mahasiswa')->first();
                debug($data_mahasiswa);
                $data_pembimbing_satu = Dosen::where('nidn', $data['pembimbing_satu_nidn'])->pluck('id_dosen')->first();
                debug($data_pembimbing_satu);
                $data_pembimbing_dua = Dosen::where('nidn', $data['pembimbing_dua_nidn'])->pluck('id_dosen')->first();
                debug($data_pembimbing_dua);
                $data_create =[
                    'id_proposal_ta' => $nextNumber,  
                    'mahasiswa_id' => $data_mahasiswa,
                    'judul' => $data['judul'],
                    'file_proposal' => $file_default,
                    'pembimbing_satu' => $data_pembimbing_satu,
                    'pembimbing_dua' => $data_pembimbing_dua,
                    'jenis_kbk_id' => $jenis_kbk_default,
                ];
                //dd($data_create);
                ProposalTAModel::create($data_create);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyinkronkan data: ' . $e->getMessage());
        }
        return redirect()->route('mahasiswa')->with('success', 'Data berhasil disinkronkan.');
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_proposal_ta  = ProposalTAModel::pluck('id_proposal_ta')->toArray();
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_proposal_ta )) {
                return $i;
                break;
            }
        }
        return $i;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $response = Http::get('https://umkm-pnp.com/heni/index.php?folder=mahasiswa&file=proposal');

            if ($response->successful()) {
                // Mengambil data dari database berdasarkan urutan descending id_proposalta
                $dataBase_proposalta = ProposalTAModel::with('r_mahasiswa')->get()->pluck('r_mahasiswa.nim')->toArray();
                //dd($dataBase_proposalta);
                // Mengambil data dari respons API
                $data = $response->json();
                $dataAPI_proposalta = $data['list'];

                // Mencari data yang ada di API tapi tidak ada di database
                $differencesArray = collect($dataAPI_proposalta)->reject(function ($item) use ($dataBase_proposalta) {
                    return in_array($item['nim'], $dataBase_proposalta);
                })->all();

                // Mencari data yang ada di database tapi tidak ada di API
                $differencesArrayDatabase = collect($dataBase_proposalta)->reject(function ($nim) use ($dataAPI_proposalta) {
                    return in_array($nim, array_column($dataAPI_proposalta, 'nim'));
                })->all();

                // Data yang berbeda dari database dalam format array asosiatif
                $differencesArrayDatabaseFormatted = ProposalTAModel::whereHas('r_mahasiswa', function($query) use ($differencesArrayDatabase) {
                    $query->whereIn('nim', $differencesArrayDatabase);
                })->with('r_pembimbing_satu', 'r_pembimbing_dua', 'r_mahasiswa')->get()->toArray();
                

                debug($dataBase_proposalta);
                debug($dataAPI_proposalta);
                debug($differencesArray);
                debug($differencesArrayDatabaseFormatted);

                return view('admin.content.admin.DataAPI.proposaltaAPI', [
                    'data_proposalta' => $dataAPI_proposalta,
                    'differences_api' => $differencesArray,
                    'differences_db' => $differencesArrayDatabaseFormatted
                ]);
            } else {
                Log::error('Request failed', ['status' => $response->status(), 'body' => $response->body()]);
                return view('admin.content.admin.DataAPI.proposaltaAPI')->with('error', 'Failed to fetch data');
            }
        } catch (\Exception $e) {
            Log::error('Request exception', ['exception' => $e]);
            return view('admin.content.admin.DataAPI.proposaltaAPI')->with('error', 'Exception occurred');
        }
    }

    public function dashboard_admin()
    {
        $banyak_pengunggahan_rps = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_rps = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $banyak_berita_rps = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '0')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');
        // dd($banyak_berita);

        $semester_rps = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
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

        $banyak_pengunggahan_uas = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(rep_rps_uas.id_rep_rps_uas) as banyak_pengunggahan"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_pengunggahan', 'smt_thnakd.smt_thnakd');

        $banyak_verifikasi_uas = VerRpsUas::join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_rps_uas.id_ver_rps_uas) as banyak_verifikasi"))
            ->where('type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_verifikasi', 'smt_thnakd.smt_thnakd');

        $banyak_berita_uas = DB::table('ver_rps_uas')
            ->join('ver_berita_acara_detail_pivot', 'ver_rps_uas.id_ver_rps_uas', '=', 'ver_berita_acara_detail_pivot.ver_rps_uas_id')
            ->join('ver_berita_acara', 'ver_berita_acara.id_berita_acara', '=', 'ver_berita_acara_detail_pivot.berita_acara_id')
            ->join('rep_rps_uas', 'ver_rps_uas.rep_rps_uas_id', '=', 'rep_rps_uas.id_rep_rps_uas')
            ->join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select(DB::raw("smt_thnakd.smt_thnakd, COUNT(ver_berita_acara.id_berita_acara) as banyak_berita"))
            ->where('ver_berita_acara.type', '=', '1')
            ->groupBy('smt_thnakd.smt_thnakd')
            ->pluck('banyak_berita', 'smt_thnakd.smt_thnakd');

        $semester_uas = RepRpsUas::join('smt_thnakd', 'rep_rps_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
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


        $totalCounts = [
            'Diajukan' => 0,
            'Ditolak' => 0,
            'Direvisi' => 0,
            'Diterima' => 0
        ];

        foreach ($data as $value) {
            $month = $value->month;
            $status = $status_mapping[$value->status_proposal_ta];

            if (!isset($review[$month])) {
                $review[$month] = array_fill_keys($statuses, 0);
                $bulan[] = $month;
            }
            $review[$month][$status] = $value->count;
            $totalCounts[$status] += $value->count;
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

        return view('admin.content.admin.dashboard_admin', compact('totalCounts', 'banyak_pengunggahan_rps', 'banyak_verifikasi_rps', 'banyak_berita_rps', 'semester_rps', 'data_ver_rps', 'banyak_pengunggahan_uas', 'banyak_verifikasi_uas', 'banyak_berita_uas','semester_uas', 'data_ver_uas', 'review', 'statuses', 'bulan', 'data_proposal'));
    }

}
