<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apbModel extends Model
{
    use HasFactory;
    protected $table = 'perkawinan';
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'pendapatan',
        'belanja',
        'penerimaan',
        'pengeluaran'
    ];
}
