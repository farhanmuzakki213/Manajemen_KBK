<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hasilVerifikasiSoalUjian extends Model
{
    use HasFactory;

    protected $fillable = ['ver_rps_uas_id','jumlah_soal', 'soal_data'];
    protected $table = 'hasil_verifikasi_soal_ujian';
    protected $primaryKey = 'ver_rps_uas_id';
    protected $casts = [
        'soal_data' => 'array',
    ];
}
