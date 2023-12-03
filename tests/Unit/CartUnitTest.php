<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class CartUnitTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;
    private Collection $products;
    private Collection $cartProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpProducts();
        $this->setUpCartProducts();
    }

    public function testFillableAttributes()
    {
        $fillable = ['user_id', 'product_id', 'qty', 'price', 'discount'];

        $this->assertEquals($this->cartProducts[0]->getFillable(), $fillable);
    }

    public function testCartBelongstoUser()
    {
        $this->assertEquals($this->cartProducts[0]->user->id, $this->users[0]->id);
    }

    public function testProductBelongstoUser()
    {
        $this->assertEquals($this->cartProducts[0]->product->id, $this->products[0]->id);
    }

    public function testGetTotalPrice()
    {
        $this->assertEquals(
            $this->cartProducts[0]->totalPrice,
            $this->cartProducts[0]->price * $this->cartProducts[0]->qty
        );
    }

    public function testGetDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->cartProducts[0]->discountedPrice,
            $this->cartProducts[0]->price * (1 - $this->cartProducts[0]->discount)
        );
    }

    public function testGetTotalDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->cartProducts[0]->totalDiscountedPrice,
            $this->cartProducts[0]->price * (1 - $this->cartProducts[0]->discount) * $this->cartProducts[0]->qty
        );
    }
}
