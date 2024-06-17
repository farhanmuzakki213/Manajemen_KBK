<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProposalTAModel extends Model
{
    use HasFactory;
    protected $fillable = ['id_penugasan','proposal_ta_id', 'reviewer_satu', 'reviewer_dua', 'pimpinan_prodi_id', 'status_final_proposal', 'tanggal_penugasan'];
    protected $table = 'review_proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_penugasan';
    public $incrementing = false;

    public function proposal_ta(){
        return $this->belongsTo(ProposalTAModel::class, 'proposal_ta_id','id_proposal_ta');
    }

    public function reviewer_satu_dosen()
    {
        return $this->belongsTo(DosenKBK::class, 'reviewer_satu', 'id_dosen_kbk');
    }

    public function reviewer_dua_dosen()
    {
        return $this->belongsTo(DosenKBK::class, 'reviewer_dua', 'id_dosen_kbk');
    }
    
    public function pimpinan_prodi_dosen()
    {
        return $this->belongsTo(PimpinanProdi::class, 'pimpinan_prodi_id', 'id_pimpinan_prodi');
    }


    public function p_reviewDetail()
    {
        return $this->hasMany(ReviewProposalTaDetailPivot::class, 'penugasan_id', 'id_penugasan');
    }

    public function review_proposal_ta_detail()
    {
        return $this->hasOne(ReviewProposalTaDetailPivot::class, 'penugasan_id', 'id_penugasan');
    }
    
}
