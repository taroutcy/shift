<?php

use Illuminate\Database\Seeder;

class WorkStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_statuses') -> insert([
            [
                'id' => '1', 
                'name' => '出勤', 
            ],
            [
                'id' => '2', 
                'name' => '欠勤', 
            ],
            [
                'id' => '3', 
                'name' => '有給', 
            ],
        ]);
    }
}
