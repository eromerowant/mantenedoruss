<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraSedesTable extends Migration
{
    public function up()
    {
        Schema::create('carrera_sedes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('carrera_id')->nullable();
            $table->foreign('carrera_id')->references('id')->on('carreras')->onDelete('set null');

            $table->unsignedBigInteger('sede_id')->nullable();
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrera_sedes');
    }
}
