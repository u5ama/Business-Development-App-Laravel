<?php

namespace Modules\User\Database\Seeders;

use Modules\User\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmailrequestlogSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        // $users = Users::all();
        $users = Users::all()->pluck('id');
        $users_count = $users->count();
        
        for ($i=0; $i < $users_count; $i++) { 
            Log::info($users);
            $user = new Users();
            $user->emailrequestlog()->create(['remaining' => '100', 'maximum' => '100', 'users_id' => $users[$i]]); 
        }
    }
}
