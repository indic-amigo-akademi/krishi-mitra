<?php

namespace Tests\Feature;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;

    /**
     * Setup for the Admin Auth Test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
    }

    /**
     * Test if the user can access the admin route.
     *
     * @param [type] $url
     * @param array $status
     * @param array $redirectUri
     * @param string $fromUri
     * @return void
     */
    protected function testAdminSingleGetRoute(
        $url,
        $status = [],
        $redirectUri = ["guest" => '/login'],
        $fromUri = ROUTE_EXPLORE
    ) {
        $default_status = ["guest" => 302, "customer" => 403, "seller" => 403, "admin" => 200, "sysadmin" => 200];
        foreach ($status as $user_role => $status_code) {
            $default_status[$user_role] = $status_code;
        }
        $status = $default_status;

        $response = $this->from($fromUri)->get($url);
        if ($response->status() == 302) {
            $response->assertRedirect($redirectUri["guest"]);
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
     * Test if the user can access the admin index route.
     *
     * @return void
     */
    public function testAdminRouteIndex()
    {
        $this->testAdminSingleGetRoute(route("admin.index"));
    }

    /**
     * Test if the user can access the admin register view route.
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
            "seller" => ROUTE_EXPLORE,
            "admin" => ROUTE_EXPLORE,
            "sysadmin" => ROUTE_EXPLORE,
            "guest" => '/login'
        ];
        $this->testAdminSingleGetRoute(route("admin.register.view"), $status, $redirectUri);
    }

    /**
     * Test if the user can access the admin approval view route.
     *
     * @return void
     */
    public function testAdminRouteApprovalView()
    {
        $this->testAdminSingleGetRoute(route("admin.approval.view"));
    }

    /**
     * Test if the user can access the admin product browse route.
     *
     * @return void
     */
    public function testAdminRouteProductBrowse()
    {
        $this->testAdminSingleGetRoute(route("admin.product.browse"));
    }

    /**
     * Test if the user can access the admin browse admin route.
     *
     * @return void
     */
    public function testAdminRouteBrowseAdminView()
    {
        $status = [
            "customer" => 403,
            "seller" => 403,
            "admin" => 403
        ];
        $this->testAdminSingleGetRoute(route("admin.browse.view"), $status);
    }
}
