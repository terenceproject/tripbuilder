<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;

class TripController extends Controller
{
    public function result(Request $request)
    {
        // for this demo, leave validation

        // get post data
        $isRoundTrip = $request->input('isRoundTrip');
        $depart = $request->input('depart');
        $arrival = $request->input('arrival');
        $departDate = $request->input('departDate');
        $returnDate = $request->input('returnDate');

        $trip = new Trip();
        $tripResult = $trip->generateTrip($isRoundTrip, $depart, $arrival, $departDate, $returnDate);

        return response()->json(compact('tripResult'));
    }
}
