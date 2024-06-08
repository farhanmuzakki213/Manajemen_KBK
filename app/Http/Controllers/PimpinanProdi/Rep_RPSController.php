<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rep_RPSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_rep_rps = DB::table('ver_rps')
            ->join('rep_rps', 'ver_rps.rep_rps_id', '=', 'rep_rps.id_rep_rps')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            // ->join('ver_rps', 'rep_rps.ver_rps_id', '=', 'ver_rps.id_ver_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen as dosen_upload', 'rep_rps.dosen_id', '=', 'dosen_upload.id_dosen')
            ->join('prodi', 'dosen_upload.prodi_id', '=', 'prodi.id_prodi')
            ->join('dosen as dosen_verifikasi', 'ver_rps.dosen_id', '=', 'dosen_verifikasi.id_dosen')
            ->select('dosen_upload.nama_dosen as nama_dosen_upload','dosen_verifikasi.nama_dosen as nama_dosen_verifikasi', 'rep_rps.id_rep_rps', 'matkul.nama_matkul', 'matkul.semester', 'prodi.prodi', 'ver_rps.status_ver_rps', 'rep_rps.created_at', 'ver_rps.tanggal_diverifikasi')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_ver_rps')
            ->get();
            //dd($data_rep_rps);
        return view('admin.content.pimpinanProdi.Rep_RPS', compact('data_rep_rps'));
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
        return view('admin.content.RPS');
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
