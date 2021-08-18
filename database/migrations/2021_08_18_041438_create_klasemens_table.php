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
            $table->integer('main')->nullable();
            $table->integer('menang')->nullable();
            $table->integer('imbang')->nullable();
            $table->integer('kalah')->nullable();
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
