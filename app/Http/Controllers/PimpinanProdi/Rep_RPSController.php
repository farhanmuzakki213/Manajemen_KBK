<?php

namespace App\Http\Controllers\PimpinanProdi;

use App\Models\VerRpsUas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PimpinanProdi;
use Illuminate\Support\Facades\Auth;

class Rep_RPSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->middleware('permission:pimpinanProdi-view RepRpsProdi', ['only' => ['index', 'getDosen']]);
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
        $data_rep_rps = VerRpsUas:: with('r_pengurus.r_dosen', 'r_rep_rps_uas.r_smt_thnakd','r_rep_rps_uas.r_dosen_matkul.r_dosen')
            ->whereHas('r_rep_rps_uas.r_smt_thnakd', function ($query) {
                $query->where('status_smt_thnakd', '=', '1'); 
            })
            ->whereHas('r_rep_rps_uas', function ($query) {
                $query->where('type', '=', '0'); 
            })
            ->orderByDesc('id_ver_rps_uas')
            ->get();
            debug($data_rep_rps);
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
