<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::factory()->sysadmin()->create();
        $this->admin = User::factory()->admin()->create();
        $this->seller = User::factory()->seller()->create();
        $this->customer = User::factory()->create();
    }

    /**
     * Test if the admin can access the admin route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @param string $fromUri
     * @return void
     */
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
     * Test if the admin can access the admin index route.
     *
     * @return void
     */
    public function testAdminRouteIndex()
    {
        $status = [
            "guest" => 302,
            "customer" => 403,
            "seller" => 403,
            "admin" => 200,
            "sysadmin" => 200
        ];
        $this->testAdminSingleGetRoute(route("admin.index"), $status);
    }

    /**
     * Test if the admin can access the admin register view route.
     *
     * @return void
     */
    public function testAdminRouteRegisterView()
    {
        $status = [
            "admin" => 302,
            "customer" => 200,
            "seller" => 302,
        ];
        $redirectUri = [
            "seller" => '/explore',
            "admin" => '/explore',
            "sysadmin" => '/explore',
            "guest" => '/login'
        ];
        $this->testAdminSingleGetRoute(route("admin.register.view"), $status, $redirectUri);
    }

    /**
     * Test if the admin can access the admin approval view route.
     *
     * @return void
     */
    public function testAdminRouteApprovalView()
    {
        $status = [
            "guest" => 302,
            "customer" => 403,
            "seller" => 403,
            "admin" => 200,
            "sysadmin" => 200
        ];
        $this->testAdminSingleGetRoute(route("admin.approval.view"), $status);
    }

    /**
     * Test if the admin can access the admin product browse route.
     *
     * @return void
     */
    public function testAdminRouteProductBrowse()
    {
        $status = [
            "guest" => 302,
            "customer" => 403,
            "seller" => 403,
            "admin" => 200,
            "sysadmin" => 200
        ];
        $this->testAdminSingleGetRoute(route("admin.product.browse"), $status);
    }

    /**
     * Test if the admin can access the admin browse admin route.
     *
     * @return void
     */
    public function testAdminRouteBrowseAdminView()
    {
        $status = [
            "guest" => 302,
            "customer" => 403,
            "seller" => 403,
            "admin" => 403,
            "sysadmin" => 200
        ];
        $this->testAdminSingleGetRoute(route("admin.browse.view"), $status);
    }
}
