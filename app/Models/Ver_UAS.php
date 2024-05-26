<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Ver_UAS extends Model
{
    protected $fillable = [
        'id_ver_uas',
        'rep_uas_id',
        'dosen_id',
        'file_verifikasi',
        'status_ver_uas',
        'saran',
        'tanggal_diverifikasi',
    ];

    protected $table = 'ver_uas';
    public $timestamps = false;

    protected $primaryKey = 'id_ver_uas';
    public $incrementing = false;

}
