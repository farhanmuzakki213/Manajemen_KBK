<?php

namespace App\Http\Controllers\PengurusKbk;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\ReviewProposalTAModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PenugasanReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_review_proposal_ta = ReviewProposalTAModel:: with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();


        debug($data_review_proposal_ta);
        return view('admin.content.pengurusKbk.Penugasan_Review', compact('data_review_proposal_ta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextNumber = $this->getCariNomor();
        $data_mahasiswa = Mahasiswa::all();
        $data_dosen = Dosen::all();
        $data_review_proposal_ta = ReviewProposalTAModel::all();

        debug(compact('data_mahasiswa', 'data_dosen', 'data_review_proposal_ta', 'nextNumber'));
        return view('admin.content.pengurusKbk.form.penugasan_review_form', compact('data_mahasiswa', 'data_dosen', 'data_review_proposal_ta', 'nextNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'id_penugasan' => 'required',
            'nama_mahasiswa' => 'required',
            'reviewer_satu' => 'required',
            'reviewer_dua' => 'required',
            'date' => 'required|date',
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
    
        // Cek apakah data mahasiswa sudah ada di tabel review_proposal_ta
        $mahasiswaExists = ReviewProposalTAModel::where('proposal_ta_id', $request->nama_mahasiswa)->exists();
    
        if ($mahasiswaExists) {
            Session::flash('error', 'Data Mahasiswa sudah ada di tabel');
            return redirect()->route('PenugasanReview.create');
        }
    
        $data = [
            'id_penugasan' => $request->id_penugasan,
            'proposal_ta_id' => $request->nama_mahasiswa,
            'reviewer_satu' => $request->reviewer_satu,
            'reviewer_dua' => $request->reviewer_dua,
            'tanggal_penugasan' => $request->date,
        ];
    
        ReviewProposalTAModel::create($data);
    
        // Set pesan keberhasilan
        Session::flash('success', 'Data berhasil di Buat');
    
        return redirect()->route('PenugasanReview');
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
        $data_mahasiswa = Mahasiswa::all();
        $data_dosen = Dosen::all();
        $data_review_proposal_ta = ReviewProposalTAModel::all();

        debug(compact('data_dosen', 'data_penugasan_review', 'data_mahasiswa'));
        return view('admin.content.pengurusKbk.form.penugasan_review_edit', compact('data_dosen', 'data_penugasan_review', 'data_mahasiswa'));
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
            'date' => 'required|date',
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
            'reviewer_satu' => $request->reviewer_satu,
            'reviewer_dua' => $request->reviewer_dua,
            'tanggal_penugasan' => $request->date,
        ];
    
        ReviewProposalTAModel::where('id_penugasan', $id)->update($data);
        Session::flash('success', 'Data berhasil di Edit');
        return redirect()->route('PenugasanReview');
        //dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data_matkul = ReviewProposalTAModel::where('id_penugasan', $id)->first();

        if ($data_matkul) {
            ReviewProposalTAModel::where('id_penugasan', $id)->delete();
            Session::flash('success', 'Data berhasil di Hapus');
        }
        return redirect()->route('PenugasanReview');
    }

    public function hasil()
    {
        $data_review_proposal_ta = ReviewProposalTAModel:: with('proposal_ta', 'reviewer_satu_dosen', 'reviewer_dua_dosen', 'p_reviewDetail')
            ->orderByDesc('review_proposal_ta.id_penugasan')
            ->get();


        debug($data_review_proposal_ta);
        return view('admin.content.pengurusKbk.Hasil_Review', compact('data_review_proposal_ta'));
    }

    function getCariNomor() {
        // Mendapatkan semua ID dari tabel rep_rps
        $id_penugasan = ReviewProposalTAModel::pluck('id_penugasan')->toArray();
    
        // Loop untuk memeriksa nomor dari 1 sampai takhingga
        for ($i = 1; ; $i++) {
            // Jika $i tidak ditemukan di dalam array $id_rep_rps, kembalikan nilai $i
            if (!in_array($i, $id_penugasan)) {
                return $i;
                break;
            }
        }
        return $i;
    }
}
