<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class work_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_types')->insert([
            [ 'type' => '出勤'],
            [ 'type' => '有給'],
            [ 'type' => '欠勤'],
            [ 'type' => '早退'],
            [ 'type' => '半休']
        ]);       
    }
}
