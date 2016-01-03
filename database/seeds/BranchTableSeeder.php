<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,2) as $value) {
        	DB::table('branches')->insert([
	            'name' => $faker->name(),
	            'address' => $faker->address(),
	            'organization_id' => 1,
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
