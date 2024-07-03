<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThnAkademik extends Model
{
    use HasFactory;
    protected $fillabel = ['id_smt_thnakd ', 'kode_smt_thnakd ', 'smt_thnakd', 'status_smt_thnakd'];
    protected $table = 'smt_thnakd';
    protected $primaryKey = 'id_smt_thnakd';
}
