<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Suborigen;
use Faker\Generator as Faker;

use Illuminate\Support\Str;
use App\Origen;

$factory->define(Suborigen::class, function (Faker $faker) {
    return [
        'nombre'    => $faker->word,
        'codigo'    => Str::random(12),
        'origen_id' => Origen::pluck('id')[$faker->numberBetween(1,Origen::count()-1)],
    ];
});
