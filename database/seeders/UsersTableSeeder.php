<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'image' => "elon.jpg", 
                'phone' => $faker->phoneNumber,
                'role' => 0,
                'birthdate' => $faker->date,
                'height' => $faker->randomFloat(2, 150, 200), 
                'weight' => $faker->randomFloat(2, 50, 100), 
                'password' => Hash::make('password'), 
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
