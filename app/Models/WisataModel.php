<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisataModel extends Model
{
    use HasFactory;

    protected $table = 'wisata';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'image',
        'content',
        'views'
    ];
}
