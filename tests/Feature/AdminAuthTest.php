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
        $status = ["guest" => 302, "customer" => 200, "seller" => 200, "admin" => 200, "sysadmin" => 200],
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
        if ($response->status() == 403)
            $response->assertStatus(403);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["admin"]);
        else
            $response->assertStatus($status["admin"]);

        $response = $this->from($fromUri)->actingAs($this->sysadmin)->get($url);
        if ($response->status() == 403)
            $response->assertStatus(403);
        elseif ($response->status() == 302)
            $response->assertRedirect($redirectUri["sysadmin"]);
        else
            $response->assertStatus($status["sysadmin"]);

        Auth::logout();
    }

    public function testAdminRoute()
    {
        $status = [
            "admin" => 302,
            "customer" => 200,
            "seller" => 302,
        ];
        $this->testAdminSingleGetRoute(route("admin.register.view"), $status, [
            "seller" => '/explore',
            "admin" => '/explore',
            "sysadmin" => '/explore',
            "guest" => '/login'
        ]);
        $this->testAdminSingleGetRoute(route("admin.index"));
        $this->testAdminSingleGetRoute(route("admin.approval.view"));
        $this->testAdminSingleGetRoute(route("admin.browse.view"));
        $this->testAdminSingleGetRoute(route("admin.product.browse"));
    }
}
