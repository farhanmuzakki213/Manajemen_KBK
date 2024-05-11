<?php

namespace App\Http\Controllers;

use App\Models\Ver_RPS;
use App\Models\Ver_RPSModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Ver_RPSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_ver_rps = DB::table('rep_rps')
            ->join('smt_thnakd', 'rep_rps.smt_thnakd_id', '=', 'smt_thnakd.id_smt_thnakd')
            ->join('ver_rps', 'rep_rps.ver_rps_id', '=', 'ver_rps.id_ver_rps')
            ->join('matkul', 'rep_rps.matkul_id', '=', 'matkul.id_matkul')
            ->join('dosen', 'ver_rps.dosen_id', '=', 'dosen.id_dosen')
            ->select('rep_rps.*', 'ver_rps.*', 'dosen.*','matkul.*','smt_thnakd.*')
            ->where('smt_thnakd.status_smt_thnakd', '=', '1')
            ->orderByDesc('id_ver_rps')
            ->get();
            //dd($data_rps);
        return view('admin.content.Ver_RPS', compact('data_ver_rps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_dosen = DB::table('dosen')->get();

        return view('admin.content.form.ver_rps_form', compact('data_dosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_ver_rps' => 'required',
            'nama_dosen' => 'required',
            'upload_file' => 'required|file',
            'status' => 'required',
            'catatan' => 'required',
            'date' => 'required|date',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $file = $request->file('upload_file');
        $filePath = $file->store('ver_rps_files');

        $data = [
            'id_ver_rps' => $request->id_ver_rps,
            'dosen_id' => $request->nama_dosen,
            'file' => $request->upload_file,
            'status_ver_rps' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_diverifikasi' => $request->date,
        ];
        Ver_RPS::create($data);
        return redirect()->route('ver_rps')->with('success', 'Data berhasil disimpan.');
        //dd($request->all());
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
        $data_ver_rps = Ver_RPS::where('id_ver_rps', $id)->first();

        if ($data_ver_rps) {
            Ver_RPS::where('id_ver_rps', $id)->delete();
        }
        return redirect()->route('ver_rps');

        //dd($data_matkul);
    }
}
