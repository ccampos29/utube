<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $userAdmin = App\User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('hola123'),
        ]);
        $userAdmin->assignRole('admin');

        $user1 = App\User::create([
            'name' => 'Carlos Campos',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('hola123'),
        ]);
        $user1->assignRole('user');

        $user2 = App\User::create([
            'name' => 'Juan Campos',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('hola123'),
        ]);
        $user2->assignRole('user');
    }
}
