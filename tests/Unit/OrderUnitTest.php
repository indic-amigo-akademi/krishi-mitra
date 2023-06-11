<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $sellerUser, $seller, $address, $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->sellerUser = User::factory()->seller()->create();
        $this->seller = Seller::factory()->create(['user_id' => $this->sellerUser->id]);
        $this->product = Product::factory()->create(['seller_id' => $this->seller->id]);
        $this->address = Address::factory()->create(['user_id' => $this->user->id]);
        $this->order = Order::factory()->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'address_id' => $this->address->id
        ]);
    }

    public function testFillableAttributes()
    {
        $fillable = [
            'user_id',
            'product_id',
            'address_id',
            'order_id',
            'qty',
            'price',
            'discount',
            'status',
            'type',
        ];

        $this->assertEquals($this->order->getFillable(), $fillable);
    }

    public function testOrderBelongstoUser()
    {
        $this->assertEquals($this->order->user->id, $this->user->id);
    }

    public function testOrderBelongstoProduct()
    {
        $this->assertEquals($this->order->product->id, $this->product->id);
    }

    public function testOrderBelongstoAddress()
    {
        $this->assertEquals($this->order->address->id, $this->address->id);
    }

    public function testGetDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->order->discountedPrice,
            $this->order->price * (1 - $this->order->discount)
        );
    }

    public function testGetTotalPriceAttribute()
    {
        $this->assertEquals(
            $this->order->totalPrice,
            $this->order->price * $this->order->qty
        );
    }

    public function testGetTotalDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->order->totalDiscountedPrice,
            $this->order->price * (1 - $this->order->discount) * $this->order->qty
        );
    }

    public function testCategoryAttribute()
    {
        $this->assertEquals(
            $this->order->category,
            $this->order::$categories[$this->order->type]
        );
    }
}
