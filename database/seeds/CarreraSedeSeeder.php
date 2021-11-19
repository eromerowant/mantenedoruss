<?php

use Illuminate\Database\Seeder;

use App\CarreraSede;

class CarreraSedeSeeder extends Seeder
{
    public function run()
    {
        factory(CarreraSede::class, 20)->create();
    }
}
