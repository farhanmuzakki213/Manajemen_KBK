<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_dosen = Dosen::with('r_jurusan', 'r_prodi')
            ->orderByDesc('id_dosen')
            ->get();
        return view('admin.content.admin.dosen', compact('data_dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();

        return view('admin.content.admin.form.dosen_form', compact('data_jurusan', 'data_prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'required',
            'status_dosen' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen' => $request->id_dosen,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'jurusan_id' => $request->jurusan,
            'prodi_id' => $request->prodi,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $request->image,
            'status_dosen' => $request->status_dosen,
        ];
        Dosen::create($data);
        return redirect()->route('dosen');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_dosen = Dosen::with(['r_jurusan', 'r_prodi'])->findOrFail($id);
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();
    
        return view('admin.content.dosen', compact('data_dosen', 'data_jurusan', 'data_prodi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_jurusan = Jurusan::all();
        $data_prodi = Prodi::all();

        $data_dosen = Dosen::where('id_dosen', $id)->first();
        //dd(compact('data_kurikulum', 'data_matkul', 'data_jenis_kbk'));

        return view('admin.content.admin.form.dosen_edit', compact('data_jurusan', 'data_prodi', 'data_dosen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_dosen' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required',
            'nip' => 'required',
            'gender' => 'required',
            'jurusan_id' => 'required',
            'prodi_id' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'required',
            'status_dosen' => 'required',

        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = [
            'id_dosen' => $request->id_dosen,
            'nama_dosen' => $request->nama_dosen,
            'nidn' => $request->nidn,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'jurusan_id' => $request->jurusan,
            'prodi_id' => $request->prodi,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $request->image,
            'status_dosen' => $request->status_dosen,
        ];
        Dosen::where('id_dosen', $id)->update($data);
        return redirect()->route('dosen');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_dosen = Dosen::where('id_dosen', $id)->first();

        if ($data_dosen) {
            Dosen::where('id_dosen', $id)->delete();
        }
        return redirect()->route('dosen');
    }
}
