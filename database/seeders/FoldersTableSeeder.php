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
            'name'=> 'Documentos Internos del GAD de Tulcan',
            'father_folder_id'=> 1
           

        ]);
    }
}
