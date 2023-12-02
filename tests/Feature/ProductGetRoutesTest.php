<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class ProductGetRoutesTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
        $this->setUpProducts();
        $this->setUpCartProducts();
    }

    /**
     * Test if the user can access the product single route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @return void
     */
    protected function testSingleGetRoute(
        $url,
        $status = [],
        $redirectUri = [],
        $fromUri = '/explore'
    ) {
        $default_status = ["guest" => 302, "customer" => 403, "seller" => 302, "admin" => 302, "sysadmin" => 302];
        foreach ($status as $user_role => $status_code) {
            $default_status[$user_role] = $status_code;
        }
        $status = $default_status;

        $default_redirect = [
            "guest" => '/login',
            "seller" => route('seller.product.browse'),
            "admin" => route('admin.product.browse'),
            "sysadmin" => route('admin.product.browse'),
        ];
        foreach ($redirectUri as $user_role => $redirect_uri) {
            $default_redirect[$user_role] = $redirect_uri;
        }
        $redirectUri = $default_redirect;

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

    /**
     * Test if the user can access the product activate route.
     *
     * @return void
     */
    public function testProductActivateRoute()
    {
        $this->testSingleGetRoute(route("product.activate", $this->users[1]->seller->products->first()->id));
    }

    /**
     * Test if the user can access the product deactivate route.
     * 
     * @return void
     */
    public function testProductDeactivateRoute()
    {
        $this->testSingleGetRoute(route("product.deactivate", $this->users[1]->seller->products->get(2)->id));
    }
}
