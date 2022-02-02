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
        //Super Administradores
        User::create([
            'identification'=> '0000000000',
            'lastname'=> 'SUPER ADMINISTRADOR',
            'name'=> 'SUPER ADMINISTRADOR',
            'email'=> 'admin@email.com',
            'password'=> bcrypt('admin123'),
            'rol'=> -1,
            'departament_id' => 3,
            'treatment_id'=>1,
            'position_id'=>1

        ]);
        //Usuario Administrador 
        User::create([
            'identification'=> '1111111111',
            'lastname'=> 'CEVALLOS CAICEDO',
            'name'=> 'KARINA PILAR',
            'email'=> 'karinacevallos@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 0,
            'departament_id' => 3,
            'treatment_id'=>1,
            'position_id'=>1

        ]);
        //Administrador de departamento 
        User::create([
            'identification'=> '2222222222',
            'lastname'=> 'FREIRE POZO ',
            'name'=> 'CRISTIAN FERNANDO',
            'email'=> 'cristianfreire@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 1,
            'departament_id' => 3,
            'treatment_id'=>1,
            'position_id'=>1

        ]);
        //Funcionario
        User::create([
            'identification'=> '3333333333',
            'lastname'=> 'ISIZAN CUACES',
            'name'=> 'LUIS FERNANDO',
            'email'=> 'luisisizan@gmail.com',
            'password'=> bcrypt('admin123'),
            'rol'=> 2,
            'departament_id' => 3,
            'treatment_id'=>1,
            'position_id'=>1

        ]);
    }
}
