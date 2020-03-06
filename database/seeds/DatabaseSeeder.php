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
        /**注意：这里有先后顺序 */

        //user表数据填充
        $this->call(UsersTableSeeder::class);

        //topic表数据填充
        $this->call(TopicsTableSeeder::class);

        //reply表数据填充
        $this->call(RepliesTableSeeder::class);
    }
}
