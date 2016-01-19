<?php

use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
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
        	DB::table('designations')->insert([
	            'name' => $faker->name(),
                'department_id' => $faker->numberBetween(1,64),
	            'description' => $faker->text(),
	            'created_at' => $faker->dateTime('now'),
	            'updated_at' => $faker->dateTime('now'),
	        ]);
        }

    }
}
