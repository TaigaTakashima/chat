<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ChatTableSeederを読み込むように指定
        $this->call(ChatTableSeeder::class);
    }
}
