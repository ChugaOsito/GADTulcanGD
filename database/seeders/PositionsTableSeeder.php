<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            
            'name'=> 'Servidor de apoyo de servicios en la unidad de TIC',
            
           

        ]);
    }
}
