<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stuntingModel extends Model
{
    use HasFactory;
    protected $table = 'stunting';
    protected $keyType = 'integer';
    protected $primaryKey = 'tahun';
    public $timestamps = false;

    protected $fillable = [
        'tahun',
        'jumlah',
    ];
}
