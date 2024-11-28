<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idmModel extends Model
{
    use HasFactory;
    protected $table = 'idm';
    protected $keyType = 'integer';
    protected $primaryKey = 'tahun';
    public $timestamps = false;

    protected $fillable = [
        "tahun",
        "skor",
        "status",
        "targetStatus",
        "skorMinimal",
        "penambahan",
        "skorIKS",
        "skorIKE",
        "skorIKL"
    ];
}
