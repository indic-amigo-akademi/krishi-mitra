<?php

namespace Tests\Feature;

use App\User;
use App\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function user_can_add_product_to_cart()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $product = [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 'KGS',
            'price' => 10,
            'discount' => 0.3
        ];
    }
    public function user_can_add_multiple_product_to_cart()
    {
        $response=$this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $product = [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 'KGS',
            'price' => 10,
            'discount' => 0.3
        ];
        $product1 = [
            'user_id' => 1,
            'product_id' => 3,
            'quantity' => 'KGS',
            'price' => 20,
            'discount' => 0.6
        ];
        $response->post(route('cart.store'), $product);
        $response->post(route('cart.store'), $product1);
        $response->assertStatus(200);
    }
    public function cart_store()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $data = [
            'user_id' => 1,
            'product_id' => 2,
            'qty' => 1,
            'price' => 10,
            'discount' => 0.3

        ];

        $response->post(route('cart.store'), $data);

        // Your assertions here
        $response->assertStatus(200);
        
    }



    public function test_it_fails_to_destroy_if_the_user_is_unauthorized()
    {
        $this->json('DELETE', 'cart/destroy/1')
            ->assertStatus(404);
    }



    public function test_it_deletes_the_product_from_cart()
    {

        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $product = [
            'user_id' => 1,
            'product_id' => 2,
            'qty' => 1,
            'price' => 10,
            'discount' => 0.3
        ];
        //$delete = $this->post(route('cart.destroy'), $product);
        $response->json('POST', '/cart/destroy/3', $product);
        // Your assertions here
        $response->assertStatus(200);
    }
}
