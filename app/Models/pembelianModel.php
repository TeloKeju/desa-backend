<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelianModel extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    public $timestamps = false;
    protected $fillable = [
        'umkm_id',
    ];
}
