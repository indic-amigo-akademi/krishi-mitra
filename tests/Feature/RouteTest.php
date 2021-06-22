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
        $response = $this->get('/Register');

        $response->assertStatus(404);
    }
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }


    public function testLogoutPage()
    {
        $response = $this->post('/logout');

        $response->assertStatus(302);
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
    //home,customer,seller,seller register, seller create

    public function testhomepage()
    {
        $response = $this->get('/home');

        $response->assertStatus(302);

    }
    public function testcustomer()
    {
        $response = $this->get('/customer');

        $response->assertStatus(404);

    }
    public function testseller()
    {
        $response = $this->get('/seller');

        $response->assertStatus(302);

    }
    //seller routes//
    public function testregisterseller()
    {
        $response = $this->get('/seller/register');

        $response->assertStatus(302);

    }
    public function testcreateseller()
    {
        $response = $this->get('/seller/create');

        $response->assertStatus(405);

    }
    public function test_update_product_Page()
    {
        $response = $this->post('/product/update');

        $response->assertStatus(404);
    }
    public function test_store_product_Page()
    {
        $response = $this->post('/product/store');

        $response->assertStatus(302);
    }
    public function test_delete_product_Page()
    {
        $response = $this->post('/product/destroy');

        $response->assertStatus(404);
    }

    

}
