<?php

namespace Tests\Unit;

use App\Models\User;
use App\Product;
use Faker\Generator as Faker;
use App\Cart;
use App\Approval;
use Carbon\Carbon;
use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SellerCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithoutMiddleware;
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::where("id", "=", 1)->first();
        $this->admin = User::where("id", "=", 2)->first();
        $this->seller = User::where("id", "=", 11)->first();
        $this->customer = User::where("id", "=", 8)->first();
        //$this->setUpFaker();
        // $this->faker->seed(1235);
        //->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
    }
    public function testSellerSubmitApproval()
    {
        $req = [
            'name' => 'TestSeller',
            'gstin' => '6512r65',
            'aadhaar' => '333311114444',
            'trade_name' => 'UnitTestingSeller'
        ];
        log::info($req);
        $response = $this->actingAs($this->customer)->post(route('seller.create'), $req);

        $lastApproval = Approval::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastApproval);
        $this->assertEquals($lastApproval->type, 'seller_approval');
        $this->assertEquals($lastApproval->user_id, 8);
    }
    public function testSellerApprovalAccepted()
    {
        $id = Approval::all()->sortByDesc('updated_at')->first()->id;
        $req = [
            'input' => 'approve',
            'id' => $id,
        ];
        log::info($req);

        $response = $this->actingAs($this->admin)->post(route('admin.approval'), $req);
        $lastpersonapproval = User::where('id', 8)->get()[0];
        log::info($lastpersonapproval);
        $this->assertEquals($lastpersonapproval->role, 'seller');
        $z = User::where('id', 8)->get()[0];
        $z->role = 'customer';
        $z->save();
    }
}
