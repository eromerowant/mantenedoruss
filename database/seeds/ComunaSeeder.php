<?php

use Illuminate\Database\Seeder;

use App\Comuna;

class ComunaSeeder extends Seeder
{
    public function run()
    {
        factory(Comuna::class, 20)->create();
    }
}
