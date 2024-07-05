<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosenKBK extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_dosen_kbk','jenis_kbk_id', 'dosen_id'];
    protected $table = 'dosen_kbk';
    public $timestamps = false;
    protected $primaryKey = 'id_dosen_kbk';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
        // Chain fluent methods for configuration options
    }

    public function r_jenis_kbk(){
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id','id_jenis_kbk');
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }
}
