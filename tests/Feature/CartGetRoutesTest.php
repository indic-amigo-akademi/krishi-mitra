<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class CartGetRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::factory()->sysadmin()->create();
        $this->admin = User::factory()->admin()->create();
        $this->seller = User::factory()->seller()->create();
        $this->customer = User::factory()->create();

        // Customer related models
        Address::factory()->create([
            'user_id' => $this->customer->id,
        ]);

        // Seller related models
        Seller::factory()->create(['user_id' => $this->seller->id]);
        $seller_products = Product::factory()->count(3)->create([
            'seller_id' => $this->seller->seller->id,
        ]);
        $customer_cart = $seller_products->map(function ($product) {
            return Cart::factory()->create([
                'user_id' => $this->customer->id,
                'product_id' => $product->id
            ]);
        });
    }

    /**
     * Test if the user can access the get route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @return void
     */
    protected function testSingleGetRoute(
        $url,
        $status = [],
        $redirectUri = ["guest" => '/login', "admin" => '/admin/product/browse', "sysadmin" => '/admin/product/browse'],
        $fromUri = '/explore'
    ) {
        $default_status = ["customer" => 200, "seller" => 200, "admin" => 200, "sysadmin" => 200];
        foreach ($status as $user_role => $status_code) {
            $default_status[$user_role] = $status_code;
        }
        $status = $default_status;

        $response = $this->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["guest"]);
        else
            $response->assertStatus($status["guest"]);

        $response = $this->from($fromUri)->actingAs($this->customer)->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["customer"]);
        else
            $response->assertStatus($status["customer"]);

        $response = $this->from($fromUri)->actingAs($this->seller)->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["seller"]);
        else
            $response->assertStatus($status["seller"]);

        $response = $this->from($fromUri)->actingAs($this->admin)->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["admin"]);
        else
            $response->assertStatus($status["admin"]);

        $response = $this->from($fromUri)->actingAs($this->sysadmin)->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["sysadmin"]);
        else
            $response->assertStatus($status["sysadmin"]);
    }

    /**
     * Test if the user can access the cart index route.
     * 
     * @return void
     */
    public function testCartIndexRoute()
    {
        $this->testSingleGetRoute(route("cart"));
    }
}
