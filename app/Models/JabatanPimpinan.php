<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanPimpinan extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'jabatan_pimpinan';
    protected $primaryKey = 'id_jabatan_pimpinan';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('JabatanPimpinan')
            ->dontSubmitEmptyLogs();
    }
}
