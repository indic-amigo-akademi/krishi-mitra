<?php

namespace Tests\Feature;
use App\User;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testCreateProduct()
    {
       $data = [
           'id'=>3,
        'type' => 'Vegetable',
        'seller_id' => 2,
        'desc' => '<p>This is a potato<p>',
        'price' => 15,
        'name' => 'Aloo Jyoti',
        'unit' => 'KGS',
        'quantity' => '133',
        'slug' => 'aloo_jyoti',
        'discount' => 0.3,
                    ];

                    $response = $this->post(route('product.store'), $data);

// Your assertions here
$response->assertStatus(302);
                }

 public function testupdateProduct()

 {
  

    $response = $this->json('GET', 'product');
    $response->assertStatus(200);
    
    $product = [
        
     'type' => 'Vegetable',
     'seller_id' => 2,
     'desc' => '<p>This is a potato<p>',
     'price' => 15,
     'name' => 'Aloo Jyoti',
     'unit' => 'KGS',
     'quantity' => '133',
     'slug' => 'aloo_jyoti',
     'discount' => 0.3,
                 ];
        $update = $this->json('POST', '/products/update/3',['name' => "Changed for test"]);
        $update->assertStatus(404);
}


public function testDeleteProduct()
    {
        $response = $this->json('GET', 'product');
        $response->assertStatus(200);

        
    $product = [
        'id'=>3,
        'type' => 'Vegetable',
        'seller_id' => 2,
        'desc' => '<p>This is a potato<p>',
        'price' => 15,
        'name' => 'Aloo Jyoti',
        'unit' => 'KGS',
        'quantity' => '133',
        'slug' => 'aloo_jyoti',
        'discount' => 0.3,
                    ];
        $delete = $this->json('POST', '/products/destroy/3');
        $delete->assertStatus(404);
                }
}
