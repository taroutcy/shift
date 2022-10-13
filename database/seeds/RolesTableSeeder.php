<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles') -> insert([
            [
                'id' => '1', 
                'name' => '社員', 
            ],
            [
                'id' => '2', 
                'name' => '社保', 
            ],
            [
                'id' => '3', 
                'name' => 'アルバイト', 
            ],
        ]);
    }
}
