<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewProposalTAModel extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_penugasan', 'pengurus_id', 'proposal_ta_id', 'reviewer_satu', 'reviewer_dua', 'pimpinan_prodi_id', 'status_final_proposal', 'tanggal_penugasan'];
    protected $table = 'review_proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_penugasan';
    public $incrementing = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('ReviewProposalTAModel')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} ReviewProposalTADetail";
            });
    }

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

    public function r_pengurus(){
        return $this->belongsTo(Pengurus_kbk::class, 'pengurus_id','id_pengurus');
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
