<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use UserTableSeeder;

class UserDatabaseSeeder extends Seeder
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
        $this->call(EmailrequestlogSeederTableSeeder::class);
        $this->call(SmsrequestlogSeederTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
