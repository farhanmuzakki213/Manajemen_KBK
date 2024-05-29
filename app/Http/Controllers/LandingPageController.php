<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_pengurus_kbk = DB::table('pengurus_kbk')
            ->join('jenis_kbk', 'pengurus_kbk.jenis_kbk_id', '=', 'jenis_kbk.id_jenis_kbk')
            ->join('jabatan_kbk', 'pengurus_kbk.jabatan_kbk_id', '=', 'jabatan_kbk.id_jabatan_kbk')
            ->join('dosen', 'pengurus_kbk.dosen_id', '=', 'dosen.id_dosen')
            ->select('jenis_kbk.jenis_kbk', 'jabatan_kbk.jabatan', 'dosen.nama_dosen')
            ->orderByDesc('id_pengurus')
            ->get();

        $data_berita = DB::table('berita')
            ->orderByDesc('id_berita')
            ->get();
            
        return view('frontend.master', compact('data_berita', 'data_pengurus_kbk'));
        //dd(compact('data_berita', 'data_pegurus_kbk'));
    } 

    public function detail($id_berita)
    {
        $data_berita = Berita::find($id_berita);
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