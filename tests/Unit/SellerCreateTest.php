<?php

namespace Tests\Unit;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class SellerCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase, SetupTest;

    private Collection $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        //$this->setUpFaker();
        // $this->faker->seed(1235);
        //->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
    }

    public function testSellerSubmitApproval()
    {
        $data = [
            'name' => 'TestSeller',
            'gstin' => '6512r65',
            'aadhaar' => '333311114444',
            'trade_name' => 'UnitTestingSeller'
        ];
        $this->actingAs($this->users[0])->post(route('seller.register'), $data)
            ->assertStatus(302);

        $lastApproval = Approval::all()->sortByDesc('id')->first();
        $this->assertEquals(
            $lastApproval->user_id,
            1
        );
        $this->assertEquals($lastApproval->type, 'seller_new');
    }

    public function testSellerApprovalAccepted()
    {
        $data = [
            'name' => 'TestSeller',
            'gstin' => '6512r65',
            'aadhaar' => '333311114444',
            'trade_name' => 'UnitTestingSeller'
        ];
        $this->actingAs($this->users[0])->post(route('seller.register'), $data);

        $lastApproval = Approval::all()->sortByDesc('id')->first();
        $data = [
            'input' => 'approve',
            'id' => $lastApproval->id,
        ];

        $this->actingAs($this->users[2])->post(route('admin.approval'), $data);
        $lastPersonApproved = User::where('id', $lastApproval->user_id)->first();
        $this->assertEquals($lastPersonApproved->role, 'seller');
    }
}
