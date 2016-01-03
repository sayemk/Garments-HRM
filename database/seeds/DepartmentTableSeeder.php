<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,8) as $value) {
        	DB::table('departments')->insert([
	            'name' => $faker->name(),
	            'description' => $faker->text(),
	            'branch_id' => $faker->numberBetween(1,2),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }
    }
}
