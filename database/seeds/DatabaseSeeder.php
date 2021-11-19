<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(ComunaSeeder::class);
        $this->call(SedeSeeder::class);
        $this->call(EnsayoSeeder::class);
        $this->call(OrigenSeeder::class);
        $this->call(SuborigenSeeder::class);
        $this->call(CarreraSeeder::class);
        $this->call(CarreraSedeSeeder::class);
    }
}
