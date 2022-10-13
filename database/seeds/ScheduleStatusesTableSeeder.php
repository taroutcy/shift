<?php

use Illuminate\Database\Seeder;

class ScheduleStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedule_statuses') -> insert([
            [
                'id' => '1', 
                'name' => '提出', 
            ],
            [
                'id' => '2', 
                'name' => '決定', 
            ],
        ]);
    }
}
