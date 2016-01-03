<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,16) as $value) {
        	DB::table('sections')->insert([
	            'name' => $faker->name(),
	            'description' => $faker->text(),
	            'department_id' => $faker->numberBetween(1,8),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
