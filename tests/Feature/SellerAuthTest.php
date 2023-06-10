<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerAuthTest extends TestCase
{
    use RefreshDatabase;
    private $sysadmin, $admin, $seller, $customer, $seller_orders;

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
        $this->seller_orders = $seller_products->map(function ($product) {
            return Order::factory()->create([
                'user_id' => $this->customer->id,
                'product_id' => $product->id,
                'address_id' => $this->customer->addresses->first()->id,
            ]);
        });
    }

    /**
     * Test if the user can access the seller route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @return void
     */
    protected function testSellerSingleGetRoute(
        $url,
        $status = [],
        $redirectUri = ["guest" => '/login'],
        $fromUri = '/explore'
    ) {
        $default_status = ["guest" => 302, "customer" => 403, "seller" => 200, 'admin' => 403, 'sysadmin' => 403];
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

    // public function testSellerRoute()
    // {
    //     $status = ["guest" => 302, "customer" => 200, "seller" => 200, 'admin' => 403, 'sysadmin' => 403];
    //     $this->testSellerSingleGetRoute("/seller/product/edit/1");
    //     $this->testSellerSingleGetRoute("/seller/product/carrot");
    // }

    /**
     * Test if the user can access the seller index route.
     *
     * @return void
     */
    public function testSellerRouteIndex()
    {
        $this->testSellerSingleGetRoute(route("seller.index"));
    }

    /**
     * Test if the user can access the seller product browse route.
     *
     * @return void
     */
    public function testSellerRouteProductBrowse()
    {
        $this->testSellerSingleGetRoute(route("seller.product.browse"));
    }

    /**
     * Test if the user can access the seller register view route.
     *
     * @return void
     */
    public function testSellerRouteRegisterView()
    {
        $status = [
            "customer" => 200,
            "seller" => 302,
            "admin" => 302,
            "sysadmin" => 302
        ];
        $redirectUri = [
            "seller" => '/explore',
            "admin" => '/explore',
            "sysadmin" => '/explore',
            "guest" => '/login'
        ];
        $this->testSellerSingleGetRoute(route("seller.register.view"), $status, $redirectUri);
    }

    /**
     * Test if the user can access the seller order browse route.
     *
     * @return void
     */
    public function testSellerRouteOrderBrowse()
    {
        $this->testSellerSingleGetRoute(route("seller.order.browse"));
    }

    /**
     * Test if the user can access the seller order view route.
     *
     * @return void
     */
    public function testSellerRouteOrderView()
    {
        // var_dump(Order::factory()->generateOrderID(1));
        $this->testSellerSingleGetRoute(route("seller.order.view", ['id' => $this->seller_orders->first()->order_id]));
        // $this->testSellerSingleGetRoute(route("seller.order.view", ['id' => Order::factory()->generateOrderID(1)]));
    }

    /**
     * Test if the user can access the seller product create view.
     *
     * @return void
     */
    public function testSellerRouteProductCreate()
    {
        $this->testSellerSingleGetRoute(route("seller.product.create"));
    }

    /**
     * Test if the user can access the seller product edit view.
     *
     * @return void
     */
    public function testSellerRouteProductEdit()
    {
        $this->testSellerSingleGetRoute(route(
            "seller.product.edit",
            ['id' => $this->seller->seller->products->first()->id]
        ));
    }

    /**
     * Test if the user can access the seller product view.
     *
     * @return void
     */
    public function testSellerRouteProductView()
    {
        $this->testSellerSingleGetRoute(route(
            "seller.product.view",
            ['slug' => $this->seller->seller->products->first()->slug]
        ));
    }
}
