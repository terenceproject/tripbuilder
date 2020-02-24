<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flights')->insert([
            "airline" =>  "AC",
            "number" =>  "301", 
            "departure_airport" =>  "YUL", 
            "departure_time" =>  "07:35", 
            "arrival_airport" =>  "YVR", 
            "arrival_time" =>  "10:05", 
            "price" => "273.23"
        ]);
        DB::table('flights')->insert([
            "airline" => "AC",
            "number" => "302", 
            "departure_airport" => "YVR", 
            "departure_time" => "11:30", 
            "arrival_airport" => "YUL", 
            "arrival_time" => "19:11", 
            "price" => "220.63"
        ]);
    }
}
