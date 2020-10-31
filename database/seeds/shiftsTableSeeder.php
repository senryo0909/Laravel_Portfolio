<?php

use Illuminate\Database\Seeder;
use App\datavase\factories\ShiftFactory;

class shiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
      factory(Shift::class, 10)->create();    
    }
}