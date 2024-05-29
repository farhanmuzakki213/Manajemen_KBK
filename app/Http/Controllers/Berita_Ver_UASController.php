<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Berita_Ver_UASController extends Controller
{
    
    public function index()
    {
        $data_ver_soal_uas = DB::table('ver_uas')
            ->join('dosen', 'ver_uas.dosen_id', '=', 'dosen.id_dosen')
            ->join('rep_uas', 'ver_uas.rep_uas_id', '=', 'rep_uas.id_rep_uas')
            ->join('matkul', 'rep_uas.matkul_id', '=', 'matkul.id_matkul')
            ->join('smt_thnakd', 'rep_uas.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->select('ver_uas.id_ver_uas', 'ver_uas.status_ver_uas', 'ver_uas.tanggal_diverifikasi', 'ver_uas.file_verifikasi', 'dosen.nama_dosen', 'matkul.kode_matkul', 'matkul.semester', 'matkul.nama_matkul', 'smt_thnakd.status_smt_thnakd')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('ver_uas.id_ver_uas')
            ->get();

        return view('admin.content.berita_acara_ver_uas', compact('data_ver_soal_uas'));
    }


}
