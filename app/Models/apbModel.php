<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apbModel extends Model
{
    use HasFactory;
    protected $table = 'apb';
    protected $primaryKey = 'tahun';
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'pendapatan',
        'belanja',
        'penerimaan',
        'pengeluaran',
        "hasil_desa",
        "transfer",
        "lain",
        "penyelenggaraan_pemerintahan_desa",
        "pelaksanaan_pembangunan_desa",
        "pembinaan_kemasyarakatan_desa",
        "pemberdayaan_masyarakat_desa",
        'penanggulangan_bencana',
    ];
}
