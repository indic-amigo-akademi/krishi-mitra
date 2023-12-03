<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class SellerAuthTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;
    private Collection $orderProducts;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
        $this->setUpProducts();
        $this->setUpOrderProducts();
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
        $fromUri = ROUTE_EXPLORE
    ) {
        $default_status = ["guest" => 302, "customer" => 403, "seller" => 200, 'admin' => 403, 'sysadmin' => 403];
        foreach ($status as $user_role => $status_code) {
            $default_status[$user_role] = $status_code;
        }
        $status = $default_status;

        $response = $this->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["guest"]);
        } else {
            $response->assertStatus($status["guest"]);
        }

        $response = $this->from($fromUri)->actingAs($this->users[0])->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["customer"]);
        } else {
            $response->assertStatus($status["customer"]);
        }

        $response = $this->from($fromUri)->actingAs($this->users[1])->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["seller"]);
        } else {
            $response->assertStatus($status["seller"]);
        }

        $response = $this->from($fromUri)->actingAs($this->users[2])->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["admin"]);
        } else {
            $response->assertStatus($status["admin"]);
        }

        $response = $this->from($fromUri)->actingAs($this->users[3])->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["sysadmin"]);
        } else {
            $response->assertStatus($status["sysadmin"]);
        }
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
            "seller" => ROUTE_EXPLORE,
            "admin" => ROUTE_EXPLORE,
            "sysadmin" => ROUTE_EXPLORE,
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
        $this->testSellerSingleGetRoute(route("seller.order.view", ['id' => $this->orderProducts->first()->order_id]));
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
            ['id' => $this->users[1]->seller->products->first()->id]
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
            ['slug' => $this->users[1]->seller->products->first()->slug]
        ));
    }
}
