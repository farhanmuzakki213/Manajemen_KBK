<?php

namespace App\Http\Controllers\PimpinanJurusan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Pengurus_kbk;
use App\Models\PimpinanJurusan;
use App\Models\Prodi;
use App\Models\VerBeritaAcara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Berita_Ver_RPS_KajurController extends Controller
{
    public function __construct() {
        $this->middleware('permission:pimpinanJurusan-view BeritaAcaraRpsKajur', ['only' => ['index', 'getDosen']]);
        $this->middleware('permission:pimpinanJurusan-update BeritaAcaraRpsKajur', ['only' => ['edit', 'update', 'getDosen']]);
    }
    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $kajur = PimpinanJurusan::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $kajur;
    }
    public function index()
    {
        $kajur = $this->getDosen();
        $jurusan = Jurusan::where('id_jurusan', $kajur->jurusan_id)->first();
        debug($jurusan->toArray());
        $data_berita_acara = VerBeritaAcara::with([
            'p_ver_rps_uas.r_rep_rps_uas.r_matkulKbk.r_matkul',
            'p_ver_rps_uas.r_pengurus.r_dosen',
            'r_pimpinan_prodi.r_prodi',
            'r_pimpinan_jurusan.r_jurusan',
            'r_pimpinan_jurusan.r_dosen',
            'r_jenis_kbk',
        ])
            ->where('kajur', $kajur->id_pimpinan_jurusan)
            ->where('type', '=', '0')
            ->get();
            debug($data_berita_acara->toArray());
            $pengurus = Pengurus_kbk::with('r_dosen')->get();
            $prodi = Prodi::get();
        return view('admin.content.pimpinanJurusan.berita_acara_ver_rps', compact('data_berita_acara', 'jurusan', 'pengurus', 'prodi'));
    }

    public function edit(string $id){
        $beritaAcara = VerBeritaAcara::find($id);
        debug($beritaAcara);
        return view('admin.content.pimpinanJurusan.form.berita_acara_ver_rps_edit', compact('beritaAcara'));
    }

    public function update(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'id_berita_acara' => 'required',
            'Status_dari_kajur' => 'required',
            'file_berita_acara' => 'sometimes|required|mimes:pdf',
            'tanggal_diketahui_kajur' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $data = [
            'id_berita_acara' => $request->id_berita_acara,
            'Status_dari_kajur' => $request->Status_dari_kajur,
            'tanggal_diketahui_kajur' => $request->tanggal_diketahui_kajur,
        ];

        $oldData = VerBeritaAcara::where('id_berita_acara', $id)->first();

        //debug($oldData->file);
        // Memeriksa apakah ada file lama
        if ($oldData->file !== null && $request->hasFile('file_berita_acara')) {
            // Hapus file lama dari storage
            Storage::delete('public/uploads/rps/berita_acara/' . $oldData->file);
        }
        $filename = null;
        // Jika file baru diunggah, hapus file lama dan simpan file baru
        if ($request->hasFile('file_berita_acara')) {

            $file = $request->file('file_berita_acara');
            $filename = $file->getClientOriginalName(); // Mendapatkan nama asli file

            $path = 'public/uploads/rps/berita_acara/';
            $file->storeAs($path, $filename); // Simpan file dengan nama aslinya

            $data['file_berita_acara'] = $filename;
        }

        //dd($request->all());
        $VerBeritaAcara = VerBeritaAcara::find($id);

        if ($VerBeritaAcara) {
            $VerBeritaAcara->update($data);
        }
        return redirect()->route('kajur_berita_ver_rps')->with('success', 'Data berhasil diperbarui.');
    }
}
