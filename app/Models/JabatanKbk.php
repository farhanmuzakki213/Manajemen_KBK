<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanKbk extends Model
{
    use HasFactory, LogsActivity;
    protected $fillabel = [
        'jabatan', 'deskripsi'
    ];
    protected $table = 'jabatan_kbk';
    protected $primaryKey = 'id_jabatan-kbk';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('JabatanKbk')
            ->dontSubmitEmptyLogs();
    }
}
