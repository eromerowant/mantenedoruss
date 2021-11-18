<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comuna;
use Faker\Generator as Faker;

use Illuminate\Support\Str;
use App\Region;

$factory->define(Comuna::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->word,
        'codigo'    => Str::random(12),
        'region_id' => Region::pluck('id')[$faker->numberBetween(1,Region::count()-1)],
    ];
});
