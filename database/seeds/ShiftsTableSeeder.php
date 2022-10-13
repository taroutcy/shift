<?php

use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts') -> insert([
            [
                'id' => '1', 
                'name' => 'A',
                'start_time' => '9:00',
                'end_time' => '18:30'
            ], 
            [
                'id' => '2', 
                'name' => 'C',
                'start_time' => '9:30',
                'end_time' => '19:00'
            ], 
            [
                'id' => '3', 
                'name' => 'D',
                'start_time' => '9:00',
                'end_time' => '16:00'
            ], 
            [
                'id' => '4', 
                'name' => 'E',
                'start_time' => '9:00',
                'end_time' => '17:00'
            ], 
            [
                'id' => '5', 
                'name' => 'H',
                'start_time' => '9:00',
                'end_time' => '15:00'
            ], 
            [
                'id' => '6', 
                'name' => 'I',
                'start_time' => '9:00',
                'end_time' => '14:00'
            ], 
            [
                'id' => '7', 
                'name' => 'J',
                'start_time' => '13:00',
                'end_time' => '19:00'
            ],
            [
                'id' => '8', 
                'name' => 'M',
                'start_time' => '9:00',
                'end_time' => '12:00'
            ], 
            [
                'id' => '9', 
                'name' => 'S',
                'start_time' => '16:00',
                'end_time' => '19:00'
            ], 
        ]);
    }
}
