<?php

namespace App\Http\Controllers\PimpinanProdi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PimpinanProdi;
use App\Models\VerBeritaAcara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Berita_Ver_UASController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pimpinanProdi-view BeritaAcaraUasProdi', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:pimpinanProdi-update BeritaAcaraUasProdi', ['only' => ['edit', 'update', 'getDosen']]);
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
        debug($kaprodi->toArray());
        $data_berita_acara = VerBeritaAcara::with([
            'p_ver_rps_uas.r_rep_rps_uas.r_matkulKbk.r_matkul',
            'p_ver_rps_uas.r_pengurus.r_dosen',
            'r_pimpinan_prodi.r_prodi',
            'r_pimpinan_prodi.r_dosen',
            'r_pimpinan_jurusan.r_jurusan',
            'r_pimpinan_jurusan.r_dosen',
            'r_jenis_kbk',
        ])
            ->where('kaprodi', $kaprodi->id_pimpinan_prodi)
            ->whereHas('p_beritaDetail.r_ver_rps_uas.r_rep_rps_uas.r_matkulKbk.r_matkul.r_kurikulum', function ($query) use ($kaprodi) {
                $query->where('prodi_id', $kaprodi->prodi_id);
            })
            ->where('type', '=', '1')
            ->get();

        return view('admin.content.pimpinanProdi.berita_acara_ver_uas', compact('data_berita_acara'));
    }

    public function edit(string $id)
    {
        $beritaAcara = VerBeritaAcara::find($id);
        debug($beritaAcara);
        return view('admin.content.pimpinanProdi.form.berita_acara_ver_uas_edit', compact('beritaAcara'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_berita_acara' => 'required',
            'Status_dari_kaprodi' => 'required',
            'file_berita_acara' => 'sometimes|required|mimes:pdf',
            'tanggal_disetujui_kaprodi' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'id_berita_acara' => $request->id_berita_acara,
            'Status_dari_kaprodi' => $request->Status_dari_kaprodi,
            'tanggal_disetujui_kaprodi' => $request->tanggal_disetujui_kaprodi,
        ];

        $oldData = VerBeritaAcara::where('id_berita_acara', $id)->first();;
        //debug($oldData->file);
        // Memeriksa apakah ada file lama
        if ($oldData->file !== null && $request->hasFile('file_berita_acara')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/uas/berita_acara/' . $oldData->file);
        }
        $filename = null;
        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('file_berita_acara')) {

            $file = $request->file('file_berita_acara');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/uas/berita_acara/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya

            $data['file_berita_acara'] = $filename;
        }

        //dd($request->all());
        $VerBeritaAcara = VerBeritaAcara::find($id);

        if ($VerBeritaAcara) {
            $VerBeritaAcara->update($data);
        }
        return redirect()->route('berita_ver_uas')->with('success', 'Data berhasil diperbarui.');
    }
}
