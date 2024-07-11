<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThnAkademik extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_smt_thnakd', 'kode_smt_thnakd', 'smt_thnakd', 'status_smt_thnakd'];
    protected $table = 'smt_thnakd';
    public $timestamps = false;
    protected $primaryKey = 'id_smt_thnakd';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('ThnAkademik')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} ThnAkademik";
            });
    }
}
