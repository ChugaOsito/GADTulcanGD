<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departament;
class DepartamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departament::create([
            'name'=> 'Alcaldia',
            'father_departament_id'=> 1
           

        ]);
        Departament::create([
            'name'=> 'TIC',
            'father_departament_id'=> 1
           

        ]);
    }
}
