<?php

use Illuminate\Database\Seeder;

use App\Carrera;

class CarreraSeeder extends Seeder
{
    public function run()
    {
        factory(Carrera::class, 20)->create();
    }
}
