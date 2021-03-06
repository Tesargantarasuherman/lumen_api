<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopSkorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_skors', function (Blueprint $table) {
            $table->id();
            $table->string('id_pemain');
            $table->string('id_tim');
            $table->string('jumlah_gol')->default(0);
            $table->integer('id_turnamen');
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
        Schema::dropIfExists('top_skors');
    }
}
