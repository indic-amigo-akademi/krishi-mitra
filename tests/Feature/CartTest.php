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
        $product =[
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 'KGS',
            'price' => 10,
            'discount' => 0.3
        ];

        
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
        $response->json('POST', '/cart/destroy/3',$product);
        // Your assertions here
        $response->assertStatus(200);
    }
  /*  public function it_can_increment_numeric_values_inside_collections()
    {
        $data = new Collection([
            'qty' => 0,
        ]);

        $this->assertSame(0, $data->get('qty'));

        $this->assertSame(1, $data->increment('qty', 1)->get('qty'));
        $this->assertSame(1, $data->get('amount'));

        $this->assertSame(0, $data->increment('qty', -1)->get('qty'));
        $this->assertSame(0, $data->get('qty'));
        $this->json('POST', '/cart/increment/');
        $this->assertStatus(200);
    }
    public function it_can_decrement_numeric_values_inside_collections()
    {
        $data = new Collection([
            'qty' => 10,
        ]);

        $this->assertSame(10, $data->get('qty'));

        $this->assertSame(9, $data->decrement('qty', 1)->get('qty'));
        $this->assertSame(9, $data->get('qty'));

        $this->assertSame(10, $data->decrement('qty', -1)->get('qty'));
        $this->assertSame(10, $data->get('qty'));
        $this->json('POST', '/cart/decrement/');
        $this->assertStatus(200);
    }*/
}
