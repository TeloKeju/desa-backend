<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentModel extends Model
{
    use HasFactory;
    protected $table = 'comment';
    public $timestamps = false;

    protected $fillable = [
        "nama",
        "rating",
        "date",
        "comment",
        "umkm_id",

    ];

    public function umkm()
    {
        return $this->belongsTo(UmkmModel::class);
    }
}
