<?php

namespace Tests\Feature;

use App\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;


class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::where("id", "=", 1)->first();
        $this->admin = User::where("id", "=", 2)->first();
        $this->seller = User::where("id", "=", 11)->first();
        $this->customer1 = User::where("id", "=", 20)->first();
        $this->customer2 = User::where("id", "=", 21)->first();
        $this->dummy_customer = User::where("id", "=", 8)->first();
        $this->setUpFaker();
        // $this->faker->seed(1235);
    }

    public function test_admin_register()
    {
        $data1 = [
            'email' => $this->customer1->email,
            'password' => 'Mohan@1999'
        ];

        $data2 = [
            'email' => $this->customer2->email,
            'password' => 'Mohan@1999'
        ];

        $response1 = $this->actingAs($this->customer1)->post(route('admin.register'), $data1);

        Auth::logout();
        $response2 = $this->actingAs($this->customer2)->post(route('admin.register'), $data2);
        $lastApproval1 = Approval::all()->where('type', '=', 'admin_approval')->sortByDesc('id')->first();
        $lastApproval2 = Approval::all()->where('type', '=', 'admin_approval')->sortBy('id')->first();
        $this->assertEquals($lastApproval1->type, 'admin_approval');
        $this->assertEquals($lastApproval2->type, 'admin_approval');
        $this->assertEquals($lastApproval1->user_id, $this->customer2->id);
        $this->assertEquals($lastApproval2->user_id, $this->customer1->id);
    }

    public function test_approval()
    {
        $lastApproval1 = Approval::all()->where('type', '=', 'admin_approval')->sortByDesc('id')->first();
        $lastApproval2 = Approval::all()->where('type', '=', 'admin_approval')->sortBy('id')->first();

        $seller_data = [
            'user_id' => $this->dummy_customer->id,
            'type' => 'seller_approval',
        ];
        $sellerApproval = Approval::create($seller_data);

        $data1 = ['input' => 'approve', 'id' => $lastApproval2->id];
        $data2 = ['input' => 'decline', 'id' => $lastApproval1->id];
        $seller_data = ['input' => 'approve', 'id' => $sellerApproval->id];
        $response1 = $this->actingAs($this->admin)->post(route('admin.approval'), $data1);
        $response2 = $this->actingAs($this->admin)->post(route('admin.approval'), $data2);
        $response3 = $this->actingAs($this->admin)->post(route('admin.approval'), $seller_data);

        $c1 = User::all()
            ->where('id', '=', $lastApproval1->user_id)->first();

        $c2 = User::all()
            ->where('id', '=', $lastApproval2->user_id)->first();

        $seller = User::all()
            ->where('id', '=', $sellerApproval->user_id)->first();

        $this->assertEquals($c1->role, 'customer');
        $this->assertEquals($c2->role, 'admin');
        $this->assertEquals($seller->role, 'seller');

        $c1->role = 'customer';
        $c2->role = 'customer';
        $seller->role = 'customer';
        $c1->save();
        $c2->save();
        $seller->save();
        $response1->assertStatus(302);
        $response1->assertRedirect(route('admin.approval.view'));

        $response2->assertStatus(302);
        $response2->assertRedirect(route('admin.approval.view'));

        $response3->assertStatus(302);
        $response3->assertRedirect(route('admin.approval.view'));
    }

    public function test_admin_browse()
    {
        $data = ['input' => $this->admin->id];

        $response = $this->actingAs($this->sysadmin)->post(route('admin.browse'), $data);

        $c1 = User::all()
            ->where('id', '=', $this->admin->id)->first();

        $this->assertEquals($c1->role, 'customer');
        $c1->role = 'admin';
        $c1->save();
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.browse.view'));
    }
}
