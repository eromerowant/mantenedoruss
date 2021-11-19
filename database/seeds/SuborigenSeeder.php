<?php

use Illuminate\Database\Seeder;

use App\Suborigen;

class SuborigenSeeder extends Seeder
{
    public function run()
    {
        factory(Suborigen::class, 20)->create();
    }
}
