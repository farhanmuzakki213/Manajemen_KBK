<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisKbk extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_jenis_kbk','jenis_kbk', 'deskripsi'];
    protected $table = 'jenis_kbk';
    public $timestamps = false;
    protected $primaryKey = 'id_jenis_kbk';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
        // Chain fluent methods for configuration options
    }
}
