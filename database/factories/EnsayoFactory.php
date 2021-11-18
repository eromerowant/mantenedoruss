<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ensayo;
use Faker\Generator as Faker;

use Illuminate\Support\Str;
use App\Sede;

$factory->define(Ensayo::class, function (Faker $faker) {
    return [
        'nombre'  => $faker->word,
        'codigo'  => Str::random(12),
        'sede_id' => Sede::pluck('id')[$faker->numberBetween(1,Sede::count()-1)],
    ];
});
