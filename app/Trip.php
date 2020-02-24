<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Airline;
use App\Airport;
use App\Flight;

class Trip extends Model
{
    /**
     * generate trip by departure location, arrival location, depart date, trip route
     */
    public function generateTrip($isRoundTrip, $depart, $arrival, $departDate, $returnDate=null)
    {
        $departAirport = Airport::where('code', $depart)->first();
        $arrivalAirport = Airport::where('code', $arrival)->first();
        $flights = Flight::where('departure_airport', $depart)->where('arrival_airport', $arrival)->get();
        $returnFlights = Flight::where('departure_airport', $arrival)->where('arrival_airport', $depart)->get();
        
        $tripResult = [];
        foreach ($flights as $f) {
            $information = $f->airline . $f->number . ' from ' . $f->departure_airport . ' to ' . $f->arrival_airport;
            $information .= ' departs at ' . $departDate . ' ' . $f->departure_time .  '(' . explode('/', $departAirport->timezone)[1] . ')';
            $information .= ' and arrives at ' . $f->arrival_time  . '(' . explode('/', $arrivalAirport->timezone)[1] . ')';
            $information .= ' price: $' . $f->price;
            $tripResult[] = $information;
        }

        if ($isRoundTrip) {
            foreach ($returnFlights as $f) {
                $information = $f->airline . $f->number . ' from ' . $f->departure_airport . ' to ' . $f->arrival_airport;
                $information .= ' departs at ' . $departDate . ' ' . $f->departure_time .  '(' . explode('/', $departAirport->timezone)[1] . ')';
                $information .= ' and arrives at ' . $f->arrival_time  . '(' . explode('/', $arrivalAirport->timezone)[1] . ')';
                $information .= ' price: $' . $f->price;
                $tripResult[] = $information; 
            }
        }

        return $tripResult;
    }
}
