<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Usuario Administrador 
        User::create([
            'identification'=> '1111111111',
            'lastname'=> 'cevallos caidedo',
            'name'=> 'Karina del pilar',
            'email'=> 'karinacevallos@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 0

        ]);
        //Usuario gestor de carpetas
        User::create([
            'identification'=> '2222222222',
            'lastname'=> 'Freir Pozo',
            'name'=> 'Cristian Fernando',
            'email'=> 'cristianfreire@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 1

        ]);
        //Funcionario
        User::create([
            'identification'=> '3333333333',
            'lastname'=> 'Isizan Cuaces',
            'name'=> 'Luis Fernando',
            'email'=> 'luisisizan@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 2

        ]);
    }
}
