<?php

use Illuminate\Database\Seeder;

use App\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        factory(Region::class, 20)->create();
    }
}
