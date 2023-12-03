<?php

namespace Tests\Unit;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware, SetupTest;
    private Collection $users;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
        $this->setUpProducts();
        $this->setUpOrderProducts();
        //$this->setUpFaker();
        // $this->faker->seed(1235);
        //->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
    }

    public function test_checkout_buynow_cash()
    {
        $data = [
            'prod_id' => 1,
            'address_radio' => 1,
            'buy_type' => 'buyNow'
        ];
        log::info($data);
        $this->actingAs($this->users[1])->post(route('OrderProcessed'), $data);
        // ->assertStatus(302);
        $lastProduct = Order::where('product_id', 1)->orderBy('updated_at', 'desc')->first();
        log::info('The last product is' . $lastProduct);
        $this->assertEquals($lastProduct->address_id, $data['address_radio']);
        // $this->assertEquals($lastProduct->qty, 1);
        // $this->assertEquals($lastProduct->type, 'cod');
        $this->assertEqualsWithDelta($lastProduct->updated_at, Carbon::now()->toDateTimeString(), 2);
    }
    public function test_checkout_buynow_card()
    {
        $data = [
            'prod_id' => 1,
            'address_radio' => 1,
            'buy_type' => 'buyNow',
            'card' => 'card'
        ];
        $this->actingAs($this->users[1])->post(route('OrderProcessed'), $data);
        // ->assertStatus(302);
        $lastProduct = Order::where(['product_id' => 1, 'type' => 'card'])
            ->orderBy('updated_at', 'desc')->first();

        $this->assertEquals($lastProduct->address_id, $data['address_radio']);
        $this->assertEquals($lastProduct->qty, 1);
        // $this->assertEquals($lastProduct->type, 'card');
        $this->assertEqualsWithDelta($lastProduct->updated_at, Carbon::now()->toDateTimeString(), 2);
    }

    public function test_order_cancel()
    {
        $id = Order::where('product_id', 2)->orderBy('updated_at', 'desc')->first()->id;
        $data = [
            'input' => 'Cancel',
            'id' => $id,
        ];

        $this->actingAs($this->users[1])->post(route('orders.show.cancel.delete', $id), $data);
        //$response->assertStatus(200);
        $lastProductStatus = Order::where('id', $id)->first()->status;
        $this->assertEquals($lastProductStatus, 'cancelled');
    }

    public function test_order_delete()
    {
        $id = Order::where('product_id', 2)->orderBy('updated_at', 'desc')->first()->id;
        $req = [
            'input' => 'Delete',
            'id' => $id,
        ];
        log::info($req);
        $this->actingAs($this->users[1])->post(route('orders.show.cancel.delete', $id), $req);
        //$response->assertStatus(200);
        $lastProduct = count(Order::where('id', $id)->get());
        $this->assertEquals($lastProduct, 0);
    }
}
