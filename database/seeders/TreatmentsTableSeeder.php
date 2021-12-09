<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Treatment::create([
            
            'name'=> 'Señor',
            'abbreviation'=>'Sr'
            
           

        ]);
    }
}
