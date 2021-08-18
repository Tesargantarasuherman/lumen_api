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
            $table->string('nama_klub');
            $table->integer('poin')->default(0);
            $table->integer('main')->default(0);
            $table->integer('menang')->default(0);
            $table->integer('imbang')->default(0);
            $table->integer('kalah')->default(0);
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
