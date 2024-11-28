<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdgsModel extends Model
{
    use HasFactory;
    protected $table = 'sdgs';
    public $timestamps = false;

    protected $fillable = [
        "skorSDGsDesa",
        "desaTanpaKemiskinan",
        "desaTanpaKelaparan",
        "desaSehatDanSejahtera",
        "pendidikanDesaBerkualitas",
        "keterlibatanPerempuanDesa",
        "desaLayakAirBersihDanSanitasi",
        "desaBerenergiBersihDanTerbarukan",
        "pertumbuhanEkonomiDesaMerata",
        "infrastrukturDanInovasiDesaSesuaiKebutuhan",
        "desaTanpaKesenjangan",
        "kawasanPemukimanDesaAmanDanNyaman",
        "konsumsiDanProduksiDesaSadarLingkungan",
        "desaTanggapPerubahanIklim",
        "desaPeduliLingkunganLaut",
        "desaPeduliLingkunganDarat",
        "desaDamaiBerkeadilan",
        "kemitraanUntukPembangunanDesa",
        "kelembagaanDesaDinamisDanBudayaDesaAdaptif"
    ];
}
