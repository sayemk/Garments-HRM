<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	
        DB::table('organizations')->insert([
            'name' => $faker->name(),
            'address' => $faker->address(),
            'created_at' => $faker->dateTime('now'),
            'updated_at' => $faker->dateTime('now'),
        ]);
        
    }
}
