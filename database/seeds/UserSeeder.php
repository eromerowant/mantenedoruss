<?php

use Illuminate\Database\Seeder;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->nombre = "Administrador Lider";
        $user->cargo = "Administrador";
        $user->email = "admin@admin.com";
        $user->email_verified_at = Carbon::now('America/Santiago');
        $user->password = Hash::make('8I_sV76L2Sv');
        $user->save();
    }
}
