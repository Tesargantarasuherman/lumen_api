<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertandingansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertandingans', function (Blueprint $table) {
            $table->id();
            $table->string('id_turnamen');
            $table->string('klub_home');
            $table->string('klub_away');
            $table->string('tanggal_pertandingan');
            $table->string('lokasi_pertandingan');
            $table->string('waktu_pertandingan');
            $table->integer('skor_home')->default(0);
            $table->integer('skor_away')->default(0);
            $table->integer('status')->default(0);

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
        Schema::dropIfExists('pertandingans');
    }
}
