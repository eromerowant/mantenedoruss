<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Region;
use Faker\Generator as Faker;

use Illuminate\Support\Str;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'codigo' => Str::random(12),
    ];
});
