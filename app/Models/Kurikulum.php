<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $fillabel = [
        'kode_kurikulum', 'nama_kurikulum', 'tahun', 'prodi_id', 'status'
    ];
    protected $table = 'kurikulum';
}
