<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer("rating");
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('comment');
            $table->unsignedBigInteger('umkm_id');
            $table->foreign('umkm_id') // kolom yang menjadi foreign key
                ->references('id')   // kolom di tabel users yang menjadi referensi
                ->on('umkm')        // nama tabel yang dirujuk
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
};
