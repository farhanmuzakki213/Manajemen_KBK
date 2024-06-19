<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Http\Controllers\Controller;
use App\Models\DosenKBK;
use App\Models\Pengurus_kbk;
use App\Models\PimpinanProdi;
use App\Models\ProposalTAModel;
use App\Models\ReviewProposalTAModel;
use App\Models\User;
use App\Notifications\PenugasanDosen;
use App\Notifications\PenugasanDosenDua;
use App\Notifications\PenugasanDosenSatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PenugasanReviewController extends Controller
{

    public function getDosen()
    {
        $user = Auth::user()->name;
        $user_email = Auth::user()->email;
        $pengurus_kbk = Pengurus_kbk::whereHas('r_dosen', function ($query) use ($user, $user_email) {
            $query->where('nama_dosen', $user)
                ->where('email', $user_email);
        })->first();
        return $pengurus_kbk;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk);

        $data_proposal_ta = ProposalTAModel::where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)->orderByDesc('id_proposal_ta')->get();

        $data_review_proposal_ta = ReviewProposalTAModel::with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();


        debug($data_review_proposal_ta);
        return view('admin.content.pengurusKbk.Penugasan_Review', compact('data_proposal_ta', 'data_review_proposal_ta'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(string $id)
    {
        // Cek apakah penugasan sudah ada
        $cek_data = ReviewProposalTAModel::where('id_penugasan', $id)->first();
        debug($id);
        if ($cek_data) {
            // Jika sudah ada, kembalikan ke halaman dengan pesan error
            return redirect()->route('PenugasanReview')->with('error', 'Data sudah diambil.');
        }

        $nextNumber = $this->getCariNomor();
        $selected_proposal_ta = ProposalTAModel::with('r_mahasiswa')->where('id_proposal_ta', $id)->first();
        $pengurus_kbk = $this->getDosen();
        $data_dosen_kbk = DosenKBK::where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)->get();
        $data_pimpinan_prodi = PimpinanProdi::with('r_dosen')->where('prodi_id', $selected_proposal_ta->r_mahasiswa->prodi_id)->first();
        debug($data_pimpinan_prodi);

        // Ambil proposal TA yang terkait dengan ID proposal yang dipilih
        return view('admin.content.pengurusKbk.form.penugasan_review_form', compact(
            'data_pimpinan_prodi',
            'data_dosen_kbk',
            'nextNumber',
            'selected_proposal_ta'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_penugasan' => 'required',
            'proposal_ta_id' => 'required',
            'reviewer_satu' => 'required',
            'reviewer_dua' => 'required',
            'pimpinan_prodi' => 'required', // Pastikan ini sesuai dengan name pada form
            'date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Validasi khusus untuk memastikan reviewer satu dan dua tidak sama
        $validator->after(function ($validator) use ($request) {
            if ($request->reviewer_satu == $request->reviewer_dua) {
                $validator->errors()->add('reviewer_satu', 'Reviewer satu dan dua tidak boleh sama');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Cek apakah mahasiswa sudah ada di tabel review_proposal_ta
        $mahasiswaExists = ReviewProposalTAModel::where('proposal_ta_id', $request->proposal_ta_id)->exists();

        if ($mahasiswaExists) {
            return redirect()->route('PenugasanReview.create', ['id' => $request->proposal_ta_id])
                ->with('error', 'Data Mahasiswa sudah ada di tabel');
        }

        // Buat entri baru di ReviewProposalTAModel
        $data = [
            'id_penugasan' => $request->id_penugasan ?: $this->generateIdPenugasan(), // Auto-generate jika tidak diberikan
            'proposal_ta_id' => $request->proposal_ta_id,
            'reviewer_satu' => $request->reviewer_satu,
            'reviewer_dua' => $request->reviewer_dua,
            'pimpinan_prodi_id' => $request->pimpinan_prodi, // Pastikan ini sesuai dengan name pada form
            'tanggal_penugasan' => $request->date,
        ];
        DB::beginTransaction();
        try {
            ReviewProposalTAModel::create($data);
            $pengurus_kbk = $this->getDosen();
            $id_penugasan = $request->id_penugasan;
            $proposal_ta = ProposalTAModel::with('r_mahasiswa')->where('id_proposal_ta', $request->proposal_ta_id)->first();
            $dosenReviewSatu = DosenKBK::with('r_dosen')->where('id_dosen_kbk', $request->reviewer_satu)->first();
            $dosenKbkSatu = User::where('name', $dosenReviewSatu->r_dosen->nama_dosen)
                ->where('email', $dosenReviewSatu->r_dosen->email)->first();
            $dosenReviewDua = DosenKBK::with('r_dosen')->where('id_dosen_kbk', $request->reviewer_dua)->first();
            $dosenKbkDua = User::where('name', $dosenReviewDua->r_dosen->nama_dosen)
                ->where('email', $dosenReviewDua->r_dosen->email)->first();
            if ($dosenKbkSatu && $dosenKbkDua) {
                Notification::send([$dosenKbkSatu, $dosenKbkDua], new PenugasanDosen($proposal_ta, $pengurus_kbk, $id_penugasan));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('PenugasanReview')->with('error', 'Gagal menyimpan data penugasan.');
        }
        debug($dosenReviewSatu, $dosenReviewSatu, $dosenKbkDua, $dosenKbkDua, $id_penugasan);

        return redirect()->route('PenugasanReview')->with('success', 'Data berhasil dibuat');
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
        $pengurus_kbk = $this->getDosen();
        debug($pengurus_kbk);
        $data_dosen_kbk = DosenKBK::where('jenis_kbk_id', $pengurus_kbk->jenis_kbk_id)->get();
        $data_pimpinan_prodi = PimpinanProdi::with('r_dosen')->get();
        $data_review_proposal_ta = ReviewProposalTAModel::with('reviewer_satu_dosen', 'reviewer_dua_dosen')
            ->where('id_penugasan', $id)->first();
        $mahasiswa = ReviewProposalTAModel::with('proposal_ta.r_mahasiswa')
            ->where('id_penugasan', $id)->get();
        debug(compact('data_dosen_kbk', 'data_pimpinan_prodi', 'data_review_proposal_ta', 'mahasiswa'));
        return view('admin.content.pengurusKbk.form.penugasan_review_edit', compact('data_dosen_kbk', 'data_pimpinan_prodi', 'data_review_proposal_ta', 'mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'id_penugasan' => 'required',
            'reviewer_satu' => 'required',
            'reviewer_dua' => 'required',
            'proposal_ta_id' => 'required',
            'date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Tambahkan aturan validasi khusus untuk memeriksa reviewer_satu dan reviewer_dua
        $validator->after(function ($validator) use ($request) {
            if ($request->reviewer_satu == $request->reviewer_dua) {
                $validator->errors()->add('reviewer_satu', 'Reviewer satu dan dua tidak boleh sama');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $data = [
            'id_penugasan' => $request->id_penugasan,
            'proposal_ta_id' => $request->proposal_ta_id,
            'reviewer_satu' => $request->reviewer_satu,
            'reviewer_dua' => $request->reviewer_dua,
            'tanggal_penugasan' => $request->date,
        ];
        DB::beginTransaction();
        try {
            ReviewProposalTAModel::where('id_penugasan', $id)->update($data);
            $pengurus_kbk = $this->getDosen();
            $id_penugasan = $request->id_penugasan;
            $proposal_ta = ProposalTAModel::with('r_mahasiswa')->where('id_proposal_ta', $request->proposal_ta_id)->first();
            $dosenReviewSatu = DosenKBK::with('r_dosen')->where('id_dosen_kbk', $request->reviewer_satu)->first();
            $dosenKbkSatu = User::where('name', $dosenReviewSatu->r_dosen->nama_dosen)
                ->where('email', $dosenReviewSatu->r_dosen->email)->first();
            $dosenReviewDua = DosenKBK::with('r_dosen')->where('id_dosen_kbk', $request->reviewer_dua)->first();
            $dosenKbkDua = User::where('name', $dosenReviewDua->r_dosen->nama_dosen)
                ->where('email', $dosenReviewDua->r_dosen->email)->first();
            if ($dosenKbkSatu && $dosenKbkDua) {
                Notification::send([$dosenKbkSatu, $dosenKbkDua], new PenugasanDosen($proposal_ta, $pengurus_kbk, $id_penugasan));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('PenugasanReview')->with('error', 'Gagal menyimpan data penugasan.');
        }
        
        Session::flash('success', 'Data berhasil di Edit');
        return redirect()->route('PenugasanReview');
        //dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $penugasan = ReviewProposalTAModel::find($id);

        if ($penugasan) {
            $penugasan->delete();
            Session::flash('success', 'Data berhasil dihapus');
        }

        return redirect()->route('PenugasanReview');
    }


    public function hasil()
    {
        $data_review_proposal_ta = ReviewProposalTAModel::with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();

        /* $userRoles = Auth::user()->roles->pluck('name','name')->all(); */
        debug($data_review_proposal_ta/* , $userRoles */);
        return view('admin.content.pengurusKbk.Hasil_Review', compact('data_review_proposal_ta'));
    }

    function getCariNomor()
    {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_penugasan = ReviewProposalTAModel::pluck('id_penugasan')->toArray();

        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1;; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_penugasan)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
