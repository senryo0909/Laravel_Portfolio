<?php

use Illuminate\Database\Seeder;

class Status_descriptions_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_descriptions')->insert([
            [
              'assignment' => '申請中',
            ],
            [
                'assignment' => '差し戻し中',
            ],
            [
                'assignment' => '承認',
            ]
        ]);
    }
}
