<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CarreraSede;
use Faker\Generator as Faker;

use App\Carrera;
use App\Sede;

$factory->define(CarreraSede::class, function (Faker $faker) {
    return [
        'carrera_id' => Carrera::pluck('id')[$faker->numberBetween(1,Carrera::count()-1)],
        'sede_id' => Sede::pluck('id')[$faker->numberBetween(1,Sede::count()-1)],
    ];
});
