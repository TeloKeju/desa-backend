<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bansosModel extends Model
{
    use HasFactory;

    protected $table = 'bansos';
    public $timestamps = false;

    protected $fillable = [
        "vaksin1",
        "vaksin2",
        "bnpt",
        "blt",
        "pkh",
        "bst",
        "bantuanCaleg",
        "baznas",
    ];
}
