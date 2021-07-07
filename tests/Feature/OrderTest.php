<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Faker\Generator as Faker;
use App\Cart;
use Carbon\Carbon;
use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OrderTest extends TestCase
{
    use WithoutMiddleware;
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
        //$this->setUpFaker();
        // $this->faker->seed(1235);
        //->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
    }
    public function test_checkout_buynow_cash()
    {
        $req = [
            'prod_id' => 9,
            'address_radio' => 1,
            'buy_type' => 'buyNow'
        ];
        log::info($req);
        $response = $this->actingAs($this->seller)->post(route('OrderProcessed'), $req);
        //$response->assertStatus(200);
        $lastProduct = Order::where('product_id', 9)->orderBy('updated_at', 'desc')->first();
        log::info('The last product is' . $lastProduct);
        $this->assertEquals($lastProduct->address_id, $req['address_radio']);
        $this->assertEquals($lastProduct->qty, 1);
        log::info('Time is' . Carbon::now()->toDateTimeString());
        $this->assertEqualsWithDelta($lastProduct->updated_at, Carbon::now()->toDateTimeString(), 2);
    }
    public function test_checkout_buynow_card()
    {
        $req = [
            'prod_id' => 9,
            'address_radio' => 1,
            'buy_type' => 'buyNow',
            'card' => 'card'
        ];
        log::info($req);
        $response = $this->actingAs($this->seller)->post(route('OrderProcessed'), $req);
        //$response->assertStatus(200);
        $lastProduct = Order::where('product_id', 9)->orderBy('updated_at', 'desc')->first();
        log::info('The last product is' . $lastProduct);
        $this->assertEquals($lastProduct->address_id, $req['address_radio']);
        $this->assertEquals($lastProduct->qty, 1);
        $this->assertEqualsWithDelta($lastProduct->updated_at, Carbon::now()->toDateTimeString(), 2);
    }
    public function test_order_cancel()
    {
        $id = Order::where('product_id', 9)->orderBy('updated_at', 'desc')->first()->id;
        $req = [
            'input' => 'Cancel',
            'id' => $id,
        ];
        log::info($req);

        $response = $this->actingAs($this->seller)->post(route('orders.show.cancel.delete', $id), $req);
        //$response->assertStatus(200);
        $lastProductStatus = Order::where('id', $id)->get()[0]->status;
        $this->assertEquals($lastProductStatus, 'Cancelled');
    }
    public function test_order_delete()
    {
        $id = Order::where('product_id', 9)->orderBy('updated_at', 'desc')->first()->id;
        $req = [
            'input' => 'Delete',
            'id' => $id,
        ];
        log::info($req);
        $response = $this->actingAs($this->seller)->post(route('orders.show.cancel.delete', $id), $req);
        //$response->assertStatus(200);
        $lastProduct = count(Order::where('id', $id)->get());
        $this->assertEquals($lastProduct, 0);
    }
}
