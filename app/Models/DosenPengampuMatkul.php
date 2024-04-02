<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPengampuMatkul extends Model
{
    use HasFactory;
    protected $fillabel=['dosen_id', 'matkul_id', 'kelas_id', 'smt_thnakd_id'];
    protected $table = 'dosen_matkul';
}
