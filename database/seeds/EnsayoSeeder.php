<?php

use Illuminate\Database\Seeder;

use App\Ensayo;

class EnsayoSeeder extends Seeder
{
    public function run()
    {
        factory(Ensayo::class, 20)->create();
    }
}
