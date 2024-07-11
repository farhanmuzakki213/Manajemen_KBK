<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewProposalTaDetailPivot extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['penugasan_id','dosen', 'status_review_proposal', 'catatan', 'tanggal_review'];
    protected $table = 'review_proposal_ta_detail_pivot';
    public $timestamps = false;
    protected $primaryKey = 'penugasan_id';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('ReviewProposalTaDetailPivot')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} ReviewProposalTA";
            });
    }

    public function p_reviewProposal()
    {
        return $this->belongsTo(ReviewProposalTAModel::class, 'penugasan_id', 'id_penugasan');
    }
    
}
