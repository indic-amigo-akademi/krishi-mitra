<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartUnitTest extends TestCase
{
    use RefreshDatabase;

    private $cart, $user, $product;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->seller()->make();
        $this->product = Product::factory()->make();
        $this->cart = Cart::factory()->make(['user_id' => $this->user->id, 'product_id' => $this->product->id]);
    }

    public function testFillableAttributes()
    {
        $fillable = ['user_id', 'product_id', 'qty', 'price', 'discount'];

        $this->assertEquals($this->cart->getFillable(), $fillable);
    }

    public function testCartBelongstoUser()
    {
        $this->assertEquals($this->cart->user_id, $this->user->id);
    }

    public function testProductBelongstoUser()
    {
        $this->assertEquals($this->cart->product_id, $this->product->id);
    }

    public function testGetTotalPrice()
    {
        $this->assertEquals(
            $this->cart->totalPrice,
            $this->cart->price * $this->cart->qty
        );
    }

    public function testGetDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->cart->discountedPrice,
            $this->cart->price * (1 - $this->cart->discount)
        );
    }

    public function testGetTotalDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->cart->totalDiscountedPrice,
            $this->cart->price * (1 - $this->cart->discount) * $this->cart->qty
        );
    }
}
