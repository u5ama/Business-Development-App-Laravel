<?php

namespace Modules\Widget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SeedFakeWidgetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory(Modules\Widget\Models\Widget::class, 100)->create();
        // $this->call("OthersTableSeeder");
    }
}
