<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdgs', function (Blueprint $table) {

            $table->id();
            $table->float("skorSDGsDesa");
            $table->float("desaTanpaKemiskinan");
            $table->float("desaTanpaKelaparan");
            $table->float("desaSehatDanSejahtera");
            $table->float("pendidikanDesaBerkualitas");
            $table->float("keterlibatanPerempuanDesa");
            $table->float("desaLayakAirBersihDanSanitasi");
            $table->float("desaBerenergiBersihDanTerbarukan");
            $table->float("pertumbuhanEkonomiDesaMerata");
            $table->float("infrastrukturDanInovasiDesaSesuaiKebutuhan");
            $table->float("desaTanpaKesenjangan");
            $table->float("kawasanPemukimanDesaAmanDanNyaman");
            $table->float("konsumsiDanProduksiDesaSadarLingkungan");
            $table->float("desaTanggapPerubahanIklim");
            $table->float("desaPeduliLingkunganLaut");
            $table->float("desaPeduliLingkunganDarat");
            $table->float("desaDamaiBerkeadilan");
            $table->float("kemitraanUntukPembangunanDesa");
            $table->float("kelembagaanDesaDinamisDanBudayaDesaAdaptif");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdgs');
    }
};
