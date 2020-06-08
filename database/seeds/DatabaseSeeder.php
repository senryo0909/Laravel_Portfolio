<?php

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
        // $this->call(work_typesTableSeeder::class);
        // $this->call(managementsTableSeeder::class);
        $this->call(shiftsTableSeeder::class);
    }
}
