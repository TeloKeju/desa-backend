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
        //
        Schema::create('idm', function (Blueprint $table) {
            $table->integer("tahun")->primary();
            $table->float("skor", 8, 4);
            $table->string("status", 8, 4);
            $table->string("targetStatus", 8, 4);
            $table->float("skorMinimal", 8, 4);
            $table->float("penambahan", 8, 4);
            $table->float("skorIKS", 8, 4);
            $table->float("skorIKE", 8, 4);
            $table->float("skorIKL", 8, 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('idm');
    }
};
