<?php

use Illuminate\Database\Seeder;

use App\Sede;

class SedeSeeder extends Seeder
{
    public function run()
    {
        factory(Sede::class, 20)->create();
    }
}
