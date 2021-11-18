<?php

use Illuminate\Database\Seeder;

use App\Origen;

class OrigenSeeder extends Seeder
{
    public function run()
    {
        factory(Origen::class, 20)->create();
    }
}
