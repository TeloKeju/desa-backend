<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendudukModel extends Model
{
    use HasFactory;
    protected $table = 'penduduk';
    public $timestamps = false;
    protected $fillable = [
        'total_penduduk',
        'kepala_keluarga',
        'perempuan',
        'laki_laki',
    ];
}
