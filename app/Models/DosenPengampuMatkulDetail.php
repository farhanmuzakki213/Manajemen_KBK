<?php

namespace App\Models;


use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPengampuMatkulDetail extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'dosen_matkul_id',
        'matkul_kbk_id',
        'kelas_id',
    ];
    protected $table = 'dosen_matkul_detail_pivot';
    protected $primaryKey = 'dosen_matkul_id';
    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('DosenPengampuMatkulDetail')
            ->dontSubmitEmptyLogs();
    }
}
