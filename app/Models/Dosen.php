<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'id_dosen', 'nama_dosen', 'nidn', 'nip', 'gender', 'jurusan_id', 'prodi_id', 'email', 'password', 'image', 'status_dosen'
    ];
    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
        // Chain fluent methods for configuration options
    }

    public function r_jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }
}
