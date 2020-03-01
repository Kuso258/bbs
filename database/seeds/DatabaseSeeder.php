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
        //user表数据填充
        $this->call(UsersTableSeeder::class);

        //topic表数据填充
        $this->call(TopicsTableSeeder::class);
    }
}
