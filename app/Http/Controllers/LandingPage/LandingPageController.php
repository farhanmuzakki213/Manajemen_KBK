<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Berita;
use App\Models\DosenKBK;
use App\Models\JenisKbk;
use App\Models\Pengurus_kbk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pengurus_kbk = Pengurus_kbk::with('r_dosen', 'r_jenis_kbk', 'r_jabatan_kbk')
            ->orderByDesc('id_pengurus')
            ->get();

        $data_berita = DB::table('berita')
            ->orderBy('id_berita')
            ->get();

            $data_dosen_kbk = DosenKBK::select('jenis_kbk_id', DB::raw('count(*) as total_dosen'))
            ->groupBy('jenis_kbk_id')
            ->with('r_jenis_kbk')
            ->get();
    
    
        $kbkData = DosenKBK::select('jenis_kbk_id', DB::raw('count(*) as total_dosen'))
        ->groupBy('jenis_kbk_id')
        ->pluck('total_dosen', 'jenis_kbk_id')
        ->all();
    
    
        $jenisKbk = JenisKbk::all()->keyBy('id_jenis_kbk');

        return view('frontend.master', compact('data_berita', 'data_pengurus_kbk', 'kbkData', 'jenisKbk'));
        //dd(compact('data_berita', 'data_pegurus_kbk'));
    }

    public function detail($id)
    {
        $data_berita = Berita::find($id);
        if (!$data_berita) {
            abort(404, 'Berita tidak ditemukan');
        }
        return view('frontend.section.detail_berita_kbk', compact('data_berita'));
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
