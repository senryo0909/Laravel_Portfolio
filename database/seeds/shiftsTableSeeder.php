<?php

use Illuminate\Database\Seeder;

class shiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
              'date' => '2020-06-02',
              'start_time' => '09:00',
              'end_time' => '18:00',
              'rest_time' => '1:00',
              'total' => '8:00',
              'comments' => '最初の勤怠入力',
              'monthly_id' => '1',
              'work_type_id' => '1',
              'user_id' => '1',
        ]); 
    }
}
