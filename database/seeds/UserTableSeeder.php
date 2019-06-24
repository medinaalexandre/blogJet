<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Usuario normal';
        $user->email = 'normal@gmail.com';
        $user->password = Hash::make('normal');
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());

        $admin = new User;
        $admin->name = 'Alexandre Medina';
        $admin->email = 'alexandre@gmail.com';
        $admin->password = Hash::make('alexandre');
        $admin->save();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
    }
}
