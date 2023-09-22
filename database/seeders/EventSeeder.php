<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\User;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            $fakerDate = $faker->date;
            $formattedDate = date('Y-m-d H:i:s', strtotime($fakerDate));
        
            DB::table('events')->insert([
                'title' => $faker->sentence,
                'details' => $faker->paragraph,
                'image' => "elon.jpg",
                'date' => $formattedDate, 
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        }
    }
