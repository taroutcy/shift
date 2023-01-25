<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $months = range(1,12);
        $days = range(1,30);
        
        // admin seeder 
        $count = 1;
        foreach($months as $month) {
            foreach($days as $day) {
                if($month == 2 && $day > 28) {
                    break;
                } 
                
                DB::table('schedules') -> insert([
                    'id' => $count,
                    'user_id' => '1', 
                    'shift_id' => rand(1,2), 
                    'schedule_status_id' => '1', 
                    'work_status_id' => rand(1,3), 
                    'date' => '2023-'.str_pad($month, 2, 0, STR_PAD_LEFT).'-'.str_pad($day, 2, 0, STR_PAD_LEFT), 
                    'created_at' => null,
                    'updated_at' => null
                ]);

                $count++;
            }
        }
        
        // staff1 seeder
        foreach($months as $month) {
            foreach($days as $day) {
                if($month == 2 && $day > 28) {
                    break;
                } 
                
                DB::table('schedules') -> insert([
                    'id' => $count,
                    'user_id' => '2', 
                    'shift_id' => rand(1,9), 
                    'schedule_status_id' => '1', 
                    'work_status_id' => '1', 
                    'date' => '2023-'.str_pad($month, 2, 0, STR_PAD_LEFT).'-'.str_pad($day, 2, 0, STR_PAD_LEFT), 
                    'created_at' => null,
                    'updated_at' => null
                ]);

                $count++;
            }
        }
    }
}
