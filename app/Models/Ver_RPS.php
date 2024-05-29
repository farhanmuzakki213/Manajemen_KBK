<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Ver_RPS extends Model
{
    protected $fillable = [
        'id_ver_rps',
        'rep_rps_id',
        'dosen_id',
        'file_verifikasi',
        'status_ver_rps',
        'catatan',
        'tanggal_diverifikasi',
    ];

    protected $table = 'ver_rps';
    public $timestamps = false;

    protected $primaryKey = 'id_ver_rps';
    public $incrementing = false;

}
