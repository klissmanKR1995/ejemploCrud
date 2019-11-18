<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuzgadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('juzgados', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nombre_juzgado');
            $table->text('estatus_juzgado');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('distrito_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('distrito_id')->references('id')->on('distritos');
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
        Schema::dropIfExists('juzgados');
    }
}
