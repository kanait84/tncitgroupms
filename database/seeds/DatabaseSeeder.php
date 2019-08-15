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

    	DB::table('users')->insert([
    		'name' => 'Administrator',
    		'email' => 'admin@abbcfoundation.com',
    		'mobile' => '0545320716',
    		'type' => 'admin',
    		'd_id' => '1',
    		'sd_id' => '1',
    		'position' => 'IT Manager',



    		'password' => bcrypt('admin'),
    	]);


    }
}
