<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airports')->insert([
            "code" => "YUL",
            "city_code" => "YMQ",
            "name" => "Pierre Elliott Trudeau International", 
            "city" => "Montreal",
            "country_code" => "CA",
            "region_code" => "QC",
            "latitude" => 45.457714,
            "longitude" => -73.749908,
            "timezone" => "America/Montreal"
        ]);
        DB::table('airports')->insert([
            "code" => "YVR",
            "city_code" => "YVR",
            "name" => "Vancouver International", 
            "city" => "Vancouver", 
            "country_code" => "CA", 
            "region_code" => "BC",
            "latitude" => 49.194698, 
            "longitude" => -123.179192, 
            "timezone" => "America/Vancouver"
        ]);
    }
}
