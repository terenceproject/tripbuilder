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

        $trip = [];
        $trip = $this->oneway($trip, $flights, $departDate, $departAirport, $arrivalAirport);
        if ($isRoundTrip) {
            $trip = $this->roundtrip($trip, $returnFlights, $returnDate, $departAirport, $arrivalAirport);
        }

        $result = $this->tripResult($trip, $isRoundTrip);

        return $result;
    }

    protected function oneway($trip, $flights, $departDate, $departAirport, $arrivalAirport)
    {
        foreach ($flights as $k => $f) {
            $information = 'Depart: ';
            $information .= $f->airline . $f->number . ' from ' . $f->departure_airport . ' to ' . $f->arrival_airport;
            $information .= ' departs at ' . $departDate . ' ' . $f->departure_time .  '(' . explode('/', $departAirport->timezone)[1] . ')';
            $information .= ' and arrives at ' . $f->arrival_time  . '(' . explode('/', $arrivalAirport->timezone)[1] . ')';
            $information .= ' price: $' . $f->price;
            $trip['oneway'][$k]['info'] = $information;
            $trip['oneway'][$k]['price'] = $f->price;
        }

        return $trip;
    }

    protected function roundtrip($trip, $returnFlights, $returnDate, $departAirport, $arrivalAirport)
    {
        foreach ($returnFlights as $k => $f) {
            $information = 'Return: ';
            $information .= $f->airline . $f->number . ' from ' . $f->departure_airport . ' to ' . $f->arrival_airport;
            $information .= ' departs at ' . $returnDate . ' ' . $f->arrival_time .  '(' . explode('/', $departAirport->timezone)[1] . ')';
            $information .= ' and arrives at ' . $f->arrival_time . '(' . explode('/', $arrivalAirport->timezone)[1] . ')';
            $information .= ' price: $' . $f->price;
            $trip['roundtrip'][$k]['info'] = $information;
            $trip['roundtrip'][$k]['price'] = $f->price;
        }

        return $trip;
    }

    protected function tripResult($trip, $isRoundTrip)
    {
        $result = [];
        foreach ($trip['oneway'] as $k => $oneway) {
            if ($isRoundTrip) {
                foreach ($trip['roundtrip'] as $i => $roundtrip) {
                    $result[$k][$i]['info'] = $oneway['info'] . $roundtrip['info'];
                    $result[$k][$i]['price'] = $oneway['price'] + $roundtrip['price'];
                }
            } else {
                $result[$k][$k]['info'] = $oneway['info'];
                $result[$k][$k]['price'] = $oneway['price'];
            }
        }

        return $result;
    }
}
