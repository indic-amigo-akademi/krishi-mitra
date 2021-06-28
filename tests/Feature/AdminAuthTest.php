<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminAuthTest extends TestCase
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

    protected function testAdminSingleGetRoute(
        $url,
        $status = ["guest" => 302, "customer" => 200, "seller" => 200],
        $redirectUri = ["guest" => '/login']
    ) {
        $response = $this->get($url);
        if ($response->status() == 302)
            $response->assertRedirect($redirectUri["guest"]);
        else
            $response->assertStatus($status["guest"]);

        $response = $this->actingAs($this->customer)->get($url);
        if ($response->status() == 403)
            $response->assertStatus(403);
        else
            $response->assertStatus($status["customer"]);

        $response = $this->actingAs($this->seller)->get($url);
        if ($response->status() == 403)
            $response->assertStatus(403);
        else
            $response->assertStatus($status["seller"]);

        $response = $this->actingAs($this->admin)->get($url);
        $response->assertStatus(200);
        $response = $this->actingAs($this->sysadmin)->get($url);
        $response->assertStatus(200);

        Auth::logout();
    }

    public function testAdminRoute()
    {
        $this->testAdminSingleGetRoute(route("admin.register.view"));
        $this->testAdminSingleGetRoute(route("admin.index"));
        $this->testAdminSingleGetRoute(route("admin.approval.view"));
        $this->testAdminSingleGetRoute(route("admin.product.browse"));
    }
}
