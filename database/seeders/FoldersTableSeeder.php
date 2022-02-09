<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Folder::create([
            'departament_id'=> 1,
            'name'=> 'Documentos Internos del GAD de Tulcan',
            'father_folder_id'=> 1
           

        ]);
       
        Folder::create([
            'departament_id'=> 2,
            'name'=> 'Alcaldia',
            'father_folder_id'=> 1
           

        ]);

        Folder::create([
            'departament_id'=> 3,
            'name'=> 'Unidad de TIC',
            'father_folder_id'=> 1
           

        ]);
       
    }
}
