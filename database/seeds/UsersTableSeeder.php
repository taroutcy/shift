<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users') -> insert([
            [
                'id' => '1', 
                'password' => Hash::make('admin'), 
                'role_id' => '1', 
                'department_id' => '1', 
                'last_name' => 'admin', 
                'first_name' => 'user', 
                'number' => '0000000000',
                'active' => '1', 
                'editor' => '1'
            ],
            [
                'id' => '2', 
                'password' => Hash::make('staff'), 
                'role_id' => '2', 
                'department_id' => '2', 
                'last_name' => 'staff1', 
                'first_name' => 'user', 
                'number' => '1111111111',
                'active' => '1', 
                'editor' => '0'
            ],
            [
                'id' => '3', 
                'password' => Hash::make('staff'), 
                'role_id' => '2', 
                'department_id' => '2', 
                'last_name' => 'staff2', 
                'first_name' => 'user', 
                'number' => '2222222222',
                'active' => '1', 
                'editor' => '0'
            ],
            [
                'id' => '4', 
                'password' => Hash::make('staff'), 
                'role_id' => '3', 
                'department_id' => '3', 
                'last_name' => 'staff3', 
                'first_name' => 'user', 
                'number' => '3333333333',
                'active' => '1', 
                'editor' => '0'
            ],
        ]);
    }
}
