<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlasemensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klasemens', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tim');
            $table->integer('poin')->default(0);
            $table->integer('main')->default(0);
            $table->integer('menang')->default(0);
            $table->integer('imbang')->default(0);
            $table->integer('kalah')->default(0);
            $table->integer('gol_kemasukan')->default(0);
            $table->integer('gol_memasukan')->default(0);
            $table->integer('gol_defisit')->default(0);
            $table->integer('id_turnamen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klasemens');
    }
}
