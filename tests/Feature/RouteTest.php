<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function testForgotpasswordPage()
    {
        $response = $this->get('/forgotpassword');

        $response->assertStatus(404);
    }
    public function testresetpasswordPage()
    {
        $response = $this->get('/resetpassword');

        $response->assertStatus(404);
    }
    public function testconfirmpasswordPage()
    {
        $response = $this->get('/confirmpassword');

        $response->assertStatus(404);
    }
}
