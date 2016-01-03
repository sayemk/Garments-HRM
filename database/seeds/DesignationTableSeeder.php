<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,10) as $value) {
        	DB::table('designations')->insert([
	            'name' => $faker->name(),
	            'description' => $faker->text(),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
