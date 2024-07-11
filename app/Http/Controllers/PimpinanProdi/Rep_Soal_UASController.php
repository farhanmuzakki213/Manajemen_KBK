<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Models\RepRpsUas;
use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DosenPengampuMatkul;
use App\Models\PimpinanProdi;
use Illuminate\Support\Facades\Auth;

class Rep_Soal_UASController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->middleware('permission:pimpinanProdi-view RepUasProdi', ['only' => ['index', 'getDosen']]);
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
        $kaprodi = $this->getDosen();
        $kaprodi = $this->getDosen();
        $data_ver_rps = VerRpsUas::with([
            'r_pengurus',
            'r_pengurus.r_dosen',
            'r_rep_rps_uas',
            'r_rep_rps_uas.r_smt_thnakd',
            'r_rep_rps_uas.r_matkulKbk'
        ])
            ->where(function ($query) use ($kaprodi) {
                $query->whereHas('r_rep_rps_uas', function ($subQuery) use ($kaprodi) {
                    $subQuery->whereHas('r_matkulKbk.r_matkul.r_kurikulum', function ($nestedQuery) use ($kaprodi) {
                        $nestedQuery->where('prodi_id', $kaprodi->prodi_id);
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
            'p_matkulKbk.r_matkul', 'p_kelas', 'r_dosen', 'r_smt_thnakd', 'p_matkulKbk.r_matkul.r_kurikulum', 'p_matkulKbk.r_matkul.r_kurikulum.r_prodi'
        ])
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('p_matkulKbk.r_matkul.r_kurikulum', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })
            ->orderByDesc('id_dosen_matkul')
            ->get();


        debug($data_matkul_kbk->toArray());
        $data_array = $data_matkul_kbk->flatMap(function ($item) use ($kaprodi) {
            return $item->p_matkulKbk->flatMap(function ($matkulKbk) use ($item, $kaprodi) {
                $prodi = $matkulKbk->r_matkul->r_kurikulum;
                if ($prodi->prodi_id === $kaprodi->prodi_id) {
                    return [[
                        'nama_dosen' => $item->r_dosen->nama_dosen,
                        'smt_thnakd' => $item->r_smt_thnakd->smt_thnakd,
                        'kode_matkul' => optional($matkulKbk->r_matkul)->kode_matkul,
                        'nama_matkul' => optional($matkulKbk->r_matkul)->nama_matkul,
                        'semester' => optional($matkulKbk->r_matkul)->semester,
                        'prodi' => optional(optional($matkulKbk->r_matkul)->r_kurikulum)->r_prodi->prodi,
                    ]];
                } else {
                    return [];
                }
            });
        })->toArray();



        debug($data_array);
        $data_rep_rps = RepRpsUas::with('r_dosen_matkul', 'r_dosen_matkul.r_dosen', 'r_matkulKbk.r_matkul.r_kurikulum', 'r_matkulKbk.r_matkul.r_kurikulum.r_prodi', 'r_smt_thnakd')
            ->whereHas('r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1');
            })
            ->whereHas('r_matkulKbk.r_matkul.r_kurikulum', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
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
                'nama_matkul' => $item['nama_matkul'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
            ];
        });
        $data_array_gabungan = $data_array_formatted->map(function ($item) use ($data_rep_rps) {
            $matched_data = $data_rep_rps->first(function ($data_rep_rps_item) use ($item) {
                return $item['nama_dosen'] == optional($data_rep_rps_item->r_dosen_matkul)->r_dosen->nama_dosen
                    && $item['smt_thnakd'] == optional($data_rep_rps_item->r_smt_thnakd)->smt_thnakd
                    && $item['kode_matkul'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->kode_matkul
                    && $item['nama_matkul'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->nama_matkul
                    && $item['semester'] == optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->semester
                    && $item['prodi'] == optional(optional(optional($data_rep_rps_item->r_matkulKbk)->r_matkul)->r_kurikulum)->r_prodi->prodi;
            });
            return [
                'nama_dosen' => $item['nama_dosen'],
                'kode_matkul' => $item['kode_matkul'],
                'nama_matkul' => $item['nama_matkul'],
                'smt_thnakd' => $item['smt_thnakd'],
                'semester' => $item['semester'],
                'prodi' => $item['prodi'],
                'id_rep_rps_uas' => $matched_data ? $matched_data->id_rep_rps_uas : null,
                'tanggal_upload' => $matched_data ? $matched_data->created_at : null,
                'file' => $matched_data ? $matched_data->file : null,
            ];
        });
        $result = $data_array_gabungan->toArray();
        debug($result);
        return view('admin.content.pimpinanProdi.Rep_Soal_UAS', compact('data_ver_rps', 'result'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.content.uas');
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
