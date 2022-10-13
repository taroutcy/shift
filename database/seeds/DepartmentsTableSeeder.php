<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments') -> insert([
            [
                'id' => '1', 
                'name' => '衣料', 
            ],
            [
                'id' => '2', 
                'name' => '食品', 
            ],
            [
                'id' => '3', 
                'name' => '生活', 
            ],
            [
                'id' => '4', 
                'name' => '学生', 
            ],
        ]);
    }
}
