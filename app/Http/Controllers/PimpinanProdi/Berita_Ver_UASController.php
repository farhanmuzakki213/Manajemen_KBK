<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Berita_Ver_UASController extends Controller
{
    
    public function index()
    {
        $data_ver_soal_uas = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd')
        ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
            $query->where('status_smt_thnakd', '=', '1'); 
        })
        ->whereHas('r_rep_rps_uas', function ($query) {
            $query->where('type', '=', '1'); 
        })
        ->orderByDesc('id_ver_rps_uas')
            ->get();

        return view('admin.content.pimpinanProdi.berita_acara_ver_uas', compact('data_ver_soal_uas'));
    }


}
