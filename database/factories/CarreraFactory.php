<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Carrera;
use Faker\Generator as Faker;

use Illuminate\Support\Str;

$factory->define(Carrera::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->word,
        'codigo'    => Str::random(12),
    ];
});
