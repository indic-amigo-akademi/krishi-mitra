<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_checkout_form()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $response->json('POST', 'CheckoutForm'); 
        $response->assertStatus(200);
    }
}
