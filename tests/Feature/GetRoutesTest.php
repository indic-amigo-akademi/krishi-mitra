<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;

use Tests\TestCase;

class GetRoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::where("id", "=", 1)->first();
        $this->admin = User::where("id", "=", 2)->first();
        $this->seller = User::where("id", "=", 11)->first();
        $this->customer = User::where("id", "=", 8)->first();
    }

    protected function testSellerSingleGetRoute(
        $url,
        $status = ["customer" => 200, "seller" => 200],
        $redirectUri = ["guest" => '/login'],
        $fromUri = '/explore'
    ) {
        $response = $this->from($fromUri)->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["guest"]);

        $response = $this->from($fromUri)->actingAs($this->customer)->get($url);
        if ($response->status() == 403)
            $response->assertStatus(403);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["customer"]);
        else
            $response->assertStatus($status["customer"]);

        $response = $this->from($fromUri)->actingAs($this->seller)->get($url);
        if ($response->status() == 403)
            $response->assertStatus(403);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["seller"]);
        else
            $response->assertStatus($status["seller"]);

        $response = $this->from($fromUri)->actingAs($this->admin)->get($url);
        if ($response->status() == 200)
            $response->assertStatus(200);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["admin"]);
        $response = $this->from($fromUri)->actingAs($this->sysadmin)->get($url);
        if ($response->status() == 200)
            $response->assertStatus(200);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["sysadmin"]);

        Auth::logout();
    }

    public function testSellerRoute()
    {
        $status = [
            "seller" => 302,
            "admin" => 302,
            "customer" => 200,
            "seller" => 200,
        ];
        $this->testSellerSingleGetRoute(route("profile"));
        $this->testSellerSingleGetRoute(route("seller.register"), $status,  [
            "seller" => '/explore',
            "admin" => '/explore',
            "sysadmin" => '/explore',
            "guest" => '/login'
        ]);

        $this->testSellerSingleGetRoute(route("home"));
        $this->testSellerSingleGetRoute(route("explore"));
        $this->testSellerSingleGetRoute(route("customer.index"));
        // $this->testSellerSingleGetRoute(route("search.item"));
        $this->testSellerSingleGetRoute(route("about"));
        $this->testSellerSingleGetRoute(route("contact"));
        $this->testSellerSingleGetRoute(route("checkout"));
        $this->testSellerSingleGetRoute(route("orders"));
        $this->testSellerSingleGetRoute(route("OrderProcessed"), $status, [
            "guest" => "/login",
            "customer" => '/orders',
            "seller" => '/orders',
            "admin" => '/orders',
            "sysadmin" => '/orders'
        ]);
        // $this->testSellerSingleGetRoute(route("orders.show", 16240389968));
        $this->testSellerSingleGetRoute(route("address"));
        $this->testSellerSingleGetRoute(route("address.add.view"));
    }
}
