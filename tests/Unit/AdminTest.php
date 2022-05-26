<?php

namespace Tests\Unit;

use App\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $this->customer = User::where("id", "=", 8)->first();
        $this->setUpFaker();
    }

    public function test_admin_register()
    {
        $data = [
            'email' => $this->customer->email,
            'password' => 'Mohan@1999'
        ];
        $response1 = $this->actingAs($this->customer)->post(route('admin.register'), $data);
        $lastApproval = Approval::all()->sortByDesc('updated_at')->first();
        $this->assertEquals($lastApproval->type, 'admin_approval');
        $this->assertEquals($lastApproval->user_id, $this->customer->id);
    }

    public function test_approval()
    {
        $lastApproval1 = Approval::all()->sortByDesc('updated_at')->first();
        $approve_data = ['input' => 'approve', 'id' => $lastApproval1->id];
        $admin_obj = [
            'user_id' => $this->customer->id,
            'type' => 'admin_approval',
        ];
        $seller_obj = [
            'user_id' => $this->customer->id,
            'type' => 'seller_approval',
        ];

        $response1 = $this->actingAs($this->admin)->post(route('admin.approval'), $approve_data);
        $c1 = User::all()
            ->where('id', '=', $lastApproval1->user_id)->first();
        $this->assertEquals($c1->role, 'admin');
        $c1->role = 'customer';
        $c1->save();

        $declineApproval = Approval::create($admin_obj);
        $decline_data = ['input' => 'decline', 'id' => $declineApproval->id];
        $response2 = $this->actingAs($this->admin)->post(route('admin.approval'), $decline_data);

        $c2 = User::all()
            ->where('id', '=', $declineApproval->user_id)->first();
        $this->assertEquals($c2->role, 'customer');
        $c2->role = 'customer';
        $c2->save();

        $req = [
            'name' => 'TestSeller',
            'gstin' => '6512r65',
            'aadhaar' => '333311114444',
            'trade_name' => 'UnitTestingSeller'
        ];
        $response = $this->actingAs($this->customer)->post(route('seller.create'), $req);
        $sellerApproval = Approval::all()->sortByDesc('updated_at')->first();
        $seller_data = ['input' => 'approve', 'id' => $sellerApproval->id];
        $response3 = $this->actingAs($this->admin)->post(route('admin.approval'), $seller_data);

        $seller = User::all()
            ->where('id', '=', $sellerApproval->user_id)->first();
        $this->assertEquals($seller->role, 'seller');
        $seller->role = 'customer';
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
