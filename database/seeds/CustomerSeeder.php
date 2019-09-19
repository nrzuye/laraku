<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 50; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('customers')->insert([
    			'nik' => $faker->nik,
    			'name' => $faker->name,
    			'gender' => 'L',
                'birth_place' => $faker->city,
                'birth' => $faker->date,
                'phone' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'created_at' => $faker->date($format = 'Y-m-d', $min = 'now'),
                'updated_at' => $faker->date($format = 'Y-m-d', $min = 'now'),
    		]);
 
    	}
    }
}
