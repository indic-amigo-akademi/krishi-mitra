<?php

namespace Tests\Unit;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker, RefreshDatabase, SetupTest;

    private Collection $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpFaker();
    }

    public function test_admin_register()
    {
        $data = [
            'email' => $this->users[0]->email,
            'password' => User::factory()->passwordStr()
        ];
        $this->actingAs($this->users[0])->post(route('admin.register'), $data)
            ->assertStatus(302);
        $lastApproval = Approval::all()->sortByDesc('updated_at')->first();
        $this->assertEquals($lastApproval->type, 'admin_new');
        $this->assertEquals($lastApproval->user_id, $this->users[0]->id);
    }

    // public function test_approval()
    // {
    //     $lastApproval1 = Approval::all()->sortByDesc('updated_at')->first();
    //     $approve_data = ['input' => 'approve', 'id' => $lastApproval1->id];
    //     $admin_obj = [
    //         'user_id' => $this->users[0]->id,
    //         'type' => 'admin_approval',
    //     ];
    //     $seller_obj = [
    //         'user_id' => $this->users[0]->id,
    //         'type' => 'seller_approval',
    //     ];

    //     $response1 = $this->actingAs($this->users[2])->post(route('admin.approval'), $approve_data);
    //     $c1 = User::all()
    //         ->where('id', '=', $lastApproval1->user_id)->first();
    //     $this->assertEquals($c1->role, 'admin');
    //     $c1->role = 'customer';
    //     $c1->save();

    //     $declineApproval = Approval::create($admin_obj);
    //     $decline_data = ['input' => 'decline', 'id' => $declineApproval->id];
    //     $response2 = $this->actingAs($this->users[2])->post(route('admin.approval'), $decline_data);

    //     $c2 = User::all()
    //         ->where('id', '=', $declineApproval->user_id)->first();
    //     $this->assertEquals($c2->role, 'customer');
    //     $c2->role = 'customer';
    //     $c2->save();

    //     $req = [
    //         'name' => 'TestSeller',
    //         'gstin' => '6512r65',
    //         'aadhaar' => '333311114444',
    //         'trade_name' => 'UnitTestingSeller'
    //     ];
    //     $response = $this->actingAs($this->users[0])->post(route('seller.register'), $req);
    //     $sellerApproval = Approval::all()->sortByDesc('updated_at')->first();
    //     $seller_data = ['input' => 'approve', 'id' => $sellerApproval->id];
    //     $response3 = $this->actingAs($this->users[2])->post(route('admin.approval'), $seller_data);

    //     $seller = User::all()
    //         ->where('id', '=', $sellerApproval->user_id)->first();
    //     $this->assertEquals($seller->role, 'seller');
    //     $seller->role = 'customer';
    //     $seller->save();

    //     $response1->assertStatus(302);
    //     $response1->assertRedirect(route('admin.approval.view'));

    //     $response2->assertStatus(302);
    //     $response2->assertRedirect(route('admin.approval.view'));

    //     $response3->assertStatus(302);
    //     $response3->assertRedirect(route('admin.approval.view'));
    // }

    public function test_admin_browse()
    {
        $data = ['input' => $this->users[2]->id];

        $this->actingAs($this->users[3])->post(route('admin.browse'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.browse.view'));

        $c1 = User::where('id', '=', $this->users[2]->id)->first();
        $this->assertEquals($c1->role, 'user');
    }
}
