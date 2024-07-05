<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_jurusan', 'kode_jurusan', 'jurusan'];
    public $timestamps = false;
    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Jurusan')
            ->dontSubmitEmptyLogs();
    }
}
