<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

use Tests\TestCase;

class GetRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
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
        $seller_products->map(function ($product) {
            return Cart::factory()->create([
                'user_id' => $this->customer->id,
                'product_id' => $product->id,
            ]);
        });
        $seller_products->map(function ($product) {
            return Order::factory()->create([
                'user_id' => $this->customer->id,
                'product_id' => $product->id,
                'address_id' => $this->customer->addresses->first()->id,
            ]);
        });
    }

    /**
     * Test if the user can access the single route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @param string $fromUri
     * @return void
     */
    protected function testSingleGetRoute(
        $url,
        $status = [],
        $redirectUri = [],
        $fromUri = '/explore'
    ) {
        $default_status = ["guest" => 302, "customer" => 200, "seller" => 200, "admin" => 200, "sysadmin" => 200];
        foreach ($status as $user_role => $status_code) {
            $default_status[$user_role] = $status_code;
        }
        $status = $default_status;

        $default_redirect = [
            "guest" => '/login',
        ];
        foreach ($redirectUri as $user_role => $redirect_uri) {
            $default_redirect[$user_role] = $redirect_uri;
        }
        $redirectUri = $default_redirect;


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
    //     $status = [
    //         "seller" => 302,
    //         "admin" => 302,
    //         "customer" => 200,
    //         "seller" => 200,
    //     ];
    // $this->testSellerSingleGetRoute(route("search.item"));
    // $this->testSellerSingleGetRoute(route("OrderProcessed"), $status, [
    //     "guest" => "/login",
    //     "customer" => '/orders',
    //     "seller" => '/orders',
    //     "admin" => '/orders',
    //     "sysadmin" => '/orders'
    // ]);
    // }

    /**
     * Test if the user can access the route profile.
     * 
     * @return void
     */
    public function testProfileGetRoute()
    {
        $this->testSingleGetRoute(route("profile"));
    }

    /**
     * Test if the user can access the route home.
     * 
     * @return void
     */
    public function testHomeGetRoute()
    {
        $this->testSingleGetRoute(route("home"), ['guest' => 200]);
    }

    /**
     * Test if the user can access the route explore.
     * 
     * @return void
     */
    public function testExploreGetRoute()
    {
        $this->testSingleGetRoute(route("explore"), ['guest' => 200]);
    }

    /**
     * Test if the user can access the route contact.
     * 
     * @return void
     */
    public function testContactGetRoute()
    {
        $this->testSingleGetRoute(route("contact"), ['guest' => 200]);
    }

    /**
     * Test if the user can access the route about.
     * 
     * @return void
     */
    public function testAboutGetRoute()
    {
        $this->testSingleGetRoute(route("about"), ['guest' => 200]);
    }

    /**
     * Test if the user can access the route checkout.
     * 
     * @return void
     */
    public function testCheckoutGetRoute()
    {
        $this->testSingleGetRoute(route("checkout"));
    }

    /**
     * Test if the user can access the route orders.
     * 
     * @return void
     */
    public function testOrdersGetRoute()
    {
        $this->testSingleGetRoute(route("orders"));
    }

    /**
     * Test if the user can access the route orders show.
     * 
     * @return void
     */
    public function testOrdersShowGetRoute()
    {
        $this->testSingleGetRoute(route("orders.show", $this->customer->orders->first()->order_id), [
            'seller' => 404,
            'admin' => 404,
            'sysadmin' => 404,
        ]);
    }

    /**
     * Test if the user can access the route address.
     * 
     * @return void
     */
    public function testAddressGetRoute()
    {
        $this->testSingleGetRoute(route("address"));
    }

    /**
     * Test if the user can access the route address add view.
     * 
     * @return void
     */
    public function testAddressAddViewGetRoute()
    {
        $this->testSingleGetRoute(route("address.add.view"));
    }

    /**
     * Test if the user can access the route customer index.
     * 
     * @return void
     */
    public function testCustomerIndexGetRoute()
    {
        $this->testSingleGetRoute(route("customer.index"));
    }

    /**
     * Test if the user can access the route product view.
     * 
     * @return void
     */
    public function testProductViewGetRoute()
    {
        $this->testSingleGetRoute(route("product.view", $this->seller->seller->products->first()->slug));
    }
}
