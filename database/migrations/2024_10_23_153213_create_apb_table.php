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
        Schema::create('apb', function (Blueprint $table) {
            $table->integer("tahun")->primary();
            $table->integer("pendapatan");
            $table->integer("belanja");
            $table->integer("penerimaan");
            $table->integer("pengeluaran");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apb');
    }
};
