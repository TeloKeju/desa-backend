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
        Schema::create('bansos', function (Blueprint $table) {
            $table->id();
            $table->integer("vaksin1");
            $table->integer("vaksin2");
            $table->integer("bnpt");
            $table->integer("blt");
            $table->integer("pkh");
            $table->integer("bst");
            $table->integer("bantuanCaleg");
            $table->integer("baznas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bansos');
    }
};
