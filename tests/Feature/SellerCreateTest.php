<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellerCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testsellerRegister()
    {
        //User's data
        $data = [
            'user_id' => 1,
            'name' => 'abc pqr',
            'aadhaar' => '771817275198',
            'trade_name' => 'Green Veggies',
            'gstin' => '05RSYMF8567UABC',

        ];
        //Send post request
        $response = $this->json('POST', route('seller.create'), $data);
        //Assert it was successful
        $response->assertStatus(401);


        //Assert we received a token
        //$this->assertArrayHasKey('token',$response->json());

    }
}
