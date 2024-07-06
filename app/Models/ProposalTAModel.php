<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalTAModel extends Model
{
    use HasFactory, LogsActivity; 
    protected $fillable = ['id_proposal_ta','mahasiswa_id', 'judul', 'status_proposal_ta', 'file_proposal', 'pembimbing_satu', 'pembimbing_dua', 'jenis_kbk_id'];
    protected $table = 'proposal_ta';
    public $timestamps = false;

    protected $primaryKey = 'id_proposal_ta';
    public $incrementing = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('ProposalTAModel')
            ->dontSubmitEmptyLogs();
    }

    public function r_mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id','id_mahasiswa');
    }

    public function r_jenis_kbk()
    {
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id', 'id_jenis_kbk');
    }
    
    public function r_pembimbing_satu()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_satu', 'id_dosen');
    }

    public function r_pembimbing_dua()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_dua', 'id_dosen');
    }

    public function review_proposal_ta()
    {
        return $this->hasOne(ReviewProposalTAModel::class, 'proposal_ta_id', 'id_proposal_ta');
    }
}
