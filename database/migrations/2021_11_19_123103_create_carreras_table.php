<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('codigo');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carreras');
    }
}
