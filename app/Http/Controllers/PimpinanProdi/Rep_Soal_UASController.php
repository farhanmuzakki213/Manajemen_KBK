<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rep_Soal_UASController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_rep_soal_uas = DB::table('ver_uas')
        ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
        ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
        // ->join('ver_rps', 'rep_rps.ver_rps_id', '=', 'ver_rps.id_ver_rps')
        ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
        ->join('dosen as dosen_upload', 'rep_uas.dosen_id', '=', 'dosen_upload.id_dosen')
        ->join('prodi', 'dosen_upload.prodi_id', '=', 'prodi.id_prodi')
        ->join('dosen as dosen_verifikasi', 'ver_uas.dosen_id', '=', 'dosen_verifikasi.id_dosen')
        ->select('dosen_upload.nama_dosen as nama_dosen_upload','dosen_verifikasi.nama_dosen as nama_dosen_verifikasi', 'rep_uas.id_rep_uas', 'matkul.nama_matkul', 'matkul.semester', 'prodi.prodi', 'ver_uas.status_ver_uas', 'rep_uas.created_at', 'ver_uas.tanggal_diverifikasi')
        ->where('smt_thnakd.status_smt_thnakd', '=', '1')
        ->orderByDesc('id_ver_uas')
        ->get();
        debug($data_rep_soal_uas);
        return view('admin.content.pimpinanProdi.Rep_Soal_UAS', compact('data_rep_soal_uas'));
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
