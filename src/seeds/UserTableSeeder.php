<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();
    	
    	for($i = 0; $i < 10; $i++)
    	{
    		DB::table('users')->insert([
    			'name' => $faker->name,
    			'email' => $faker->email,
    			'password' => bcrypt('password'),
    			'created_at' => Carbon::now()
    		]);		
    	}
    }
}
