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
            'name'=> 'GAD Municipal de Tulcan',
            'father_departament_id'=> 1,
            'identifier'=>'ALC'
           

        ]);

        Departament::create([
            'name'=> 'Alcaldía',
            'father_departament_id'=> 1,
            'identifier'=>'ALC'
           

        ]);
        Departament::create([
            'name'=> 'TIC',
            'father_departament_id'=> 2,
            'identifier'=>'TIC'
        ]);
    }
}
