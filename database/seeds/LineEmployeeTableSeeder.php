<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class LineEmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        foreach (range(1,100) as $value) {
        	DB::table('line_employee')->insert([
	            'line_id' => $faker->numberBetween(1,64),
	            'employee_id' => $faker->numberBetween(1,100),
	        ]);
        }
    }
}
