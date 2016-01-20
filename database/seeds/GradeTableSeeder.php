<?php

use Illuminate\Database\Seeder;

class GradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = \Faker\Factory::create();
    	
        foreach (range(1,10) as $value) {
        	DB::table('grades')->insert([
	            'name' => $faker->name(),
                'designation_id' => $faker->numberBetween(1,64),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
