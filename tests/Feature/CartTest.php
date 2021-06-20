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
        $this->assertTrue(Cart::doesNotExist());
        $product = Product::create([
           'user_id'=>1,
           'product_id'=>2,
           'quantity'=>'KGS',
           'price'=>10,
           'discount'=>0.3
        ]);

        Cart::addItem($product);

        $this->assertTrue(Cart::exists());
    }
    public function cart_store()
    {

        $data = [
            'user_id'=>1,
            'product_id'=>2,
            'qty'=>1,
           'price'=>10,
           'discount'=>0.3

                     ];
 
                     $response = $this->post(route('cart.store'), $data);
 
 // Your assertions here
 $response->assertStatus(200);
    }

    

    public function test_it_fails_to_destroy_if_the_user_is_unauthorized()
    {
        $this->json('DELETE', 'api/cart/1')
             ->assertStatus(404);
    }

  

    public function test_it_deletes_the_product_from_cart()
    {
       

        $product = [
            'user_id'=>1,
            'product_id'=>2,
            'qty'=>1,
           'price'=>10,
           'discount'=>0.3
                        ];
                        $delete = $this->post(route('cart.destroy'), $product);
 
                        // Your assertions here
                        $delete->assertStatus(500);
    }
    public function it_can_increment_numeric_values_inside_collections()
    {
        $data = new Collection([
            'qty'=>0,
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
    }

}
