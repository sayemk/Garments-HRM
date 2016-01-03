<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class LineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,64) as $value) {
        	DB::table('lines')->insert([
	            'name' => $faker->name(),
	            'description' => $faker->text(),
	            'section_id' => $faker->numberBetween(1,16),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
