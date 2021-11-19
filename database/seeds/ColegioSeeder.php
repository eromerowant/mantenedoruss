<?php

use Illuminate\Database\Seeder;

use App\Colegio;

class ColegioSeeder extends Seeder
{
    public function run()
    {
        factory(Colegio::class, 20)->create();
    }
}
