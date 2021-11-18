<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sede;
use Faker\Generator as Faker;

use App\Region;

$factory->define(Sede::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->word,
        'region_id' => Region::pluck('id')[$faker->numberBetween(1,Region::count()-1)],
    ];
});
