<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThnAkademik extends Model
{
    use HasFactory, LogsActivity;
    protected $fillabel = ['id_smt_thnakd ', 'kode_smt_thnakd ', 'smt_thnakd', 'status_smt_thnakd'];
    protected $table = 'smt_thnakd';
    protected $primaryKey = 'id_smt_thnakd';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('ThnAkademik')
            ->dontSubmitEmptyLogs();
    }
}
