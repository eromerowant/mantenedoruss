<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Origen;
use Faker\Generator as Faker;

use Illuminate\Support\Str;

$factory->define(Origen::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->word,
        'codigo'    => Str::random(12),
    ];
});
