<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(DepartamentsTableSeeder::class);
        $this->call(TreatmentsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        
        $this->call(FoldersTableSeeder::class);
    }
}
