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
    // use RefreshDatabase;

    public function testCreateProduct()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
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
        $response->json('POST', 'product.store', $data);
        // Your assertions here
        $response->assertStatus(200);
    }

    public function testupdateProduct()

    {

        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

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
        $update = ['name' => 'changed'];
        $response->json('POST', '/products/update/3', [
            $product['id'],
            $product['type'],
            $product['seller_id'],
            $product['desc'],
            $product['price'] => 15,
            $update['name'],
            $product['unit'],
            $product['quantity'],
            $product['slug'],
            $product['discount']
        ]);
        $response->assertStatus(200);
    }
    //$user = factory(\App\User::class)->create();
    //$response = $this->actingAs($user, 'api')->json('POST', '/api/products',$data);

    public function testDeleteProduct()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

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
        $response->json('POST', '/products/destroy/3', $product);
        $response->assertStatus(200);
    }
}
