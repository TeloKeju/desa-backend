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
        Schema::create('perkawinan', function (Blueprint $table) {
            $table->id();
            $table->integer('belum_kawin');
            $table->integer('kawin');
            $table->integer('cerai_mati');
            $table->integer('cerai_hidup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perkawinan');
    }
};
