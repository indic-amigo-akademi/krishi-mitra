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

    public function testCreateProduct()
    {
        $data = [
            'id' => 3,
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
            'id' => 3,
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

        $update = $this->json('POST', '/products/update/3', ['name' => "Changed for test"]);
        //$update->assertStatus(200);
    }
    //$user = factory(\App\User::class)->create();
    //$response = $this->actingAs($user, 'api')->json('POST', '/api/products',$data);

    public function testDeleteProduct()
    {
        $response = $this->json('GET', 'product');
        $response->assertStatus(200);


        $product = [
            'id' => 3,
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
        $delete = $this->delete('/products/destroy/3');
        //$delete->assertStatus(200);
    }
}
