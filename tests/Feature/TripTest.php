<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TripTest extends TestCase
{
    /**
     * test the main page.
     *
     * @return void
     */
    public function testIndexPage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Trip Builder');
    }

    /**
     * test get all airports 
     * 
     * @return void
     */
    public function testGetAirports()
    {
        $response = $this->get('/airports');

        $response->assertStatus(200);
        $response->assertJson([
            'airports' => [],
        ]);
    }

    /**
     * test get all airlines 
     * 
     * @return void
     */
    public function testGetAirlines()
    {
        $response = $this->get('/airlines');

        $response->assertStatus(200);
        $response->assertJson([
            'airlines' => [],
        ]);

        $this->assertDatabaseHas('airlines', [
            'code' => 'AC'
        ]);
    }

     /**
     * test get all flights 
     * 
     * @return void
     */
    public function testGetFlights()
    {
        $response = $this->get('/flights');

        $response->assertStatus(200);
        $response->assertJson([
            'flights' => [],
        ]);
    }

    /**
     * test trip result by post data
     * 
     * @return void
     */
    public function testTripResult()
    {
        $response = $this->post('/trip', [
            'isRoundTrip' => false,
            'depart' =>  "YUL",
            'arrival' => "YVR",
            'departDate' => "02/24/2020",
            'returnDate' => "02/27/2020"
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'tripResult' => [],
        ]);
    }
}
