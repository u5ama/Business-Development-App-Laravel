<?php

use Illuminate\Database\Seeder;
use Modules\User\Models\Users;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'id'=>'1',
            'email'=>'admin@trustyy.com',
            'first_name'=>'System',
            'last_name'=>'Admin',
            'password' => bcrypt('admin123!@'),
            'remember_token' => '',
        ]);
    }
}
