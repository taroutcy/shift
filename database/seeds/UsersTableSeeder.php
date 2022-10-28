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
                'password' => Hash::make('testtest'), 
                'role_id' => '1', 
                'department_id' => '1', 
                'last_name' => '山田', 
                'first_name' => '太郎', 
                'number' => '0111111111',
                'active' => '1', 
                'editor' => '1'
            ],
        ]);
    }
}
