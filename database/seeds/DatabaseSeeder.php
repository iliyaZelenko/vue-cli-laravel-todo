<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Group::class, 8)->create()->each(function ($group) {
            $group->todo()->saveMany( factory(\App\Todo::class, mt_rand(3, 10) )->make() );
        });
    }
}
