<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class OrderUnitTest extends TestCase
{
    use RefreshDatabase, SetupTest;

    private Collection $users;
    private Collection $addresses;
    private Collection $products;
    private Collection $orderProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
        $this->setUpProducts();
        $this->setUpOrderProducts();
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

        $this->assertEquals($this->orderProducts[0]->getFillable(), $fillable);
    }

    public function testOrderBelongstoUser()
    {
        $this->assertEquals($this->orderProducts[0]->user->id, $this->users[0]->id);
    }

    public function testOrderBelongstoProduct()
    {
        $this->assertEquals($this->orderProducts[0]->product->id, $this->products[0]->id);
    }

    public function testOrderBelongstoAddress()
    {
        $this->assertEquals($this->orderProducts[0]->address->id, $this->addresses[0]->id);
    }

    public function testGetDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->orderProducts[0]->discountedPrice,
            $this->orderProducts[0]->price * (1 - $this->orderProducts[0]->discount)
        );
    }

    public function testGetTotalPriceAttribute()
    {
        $this->assertEquals(
            $this->orderProducts[0]->totalPrice,
            $this->orderProducts[0]->price * $this->orderProducts[0]->qty
        );
    }

    public function testGetTotalDiscountedPriceAttribute()
    {
        $this->assertEquals(
            $this->orderProducts[0]->totalDiscountedPrice,
            $this->orderProducts[0]->price * (1 - $this->orderProducts[0]->discount) * $this->orderProducts[0]->qty
        );
    }

    public function testCategoryAttribute()
    {
        $this->assertEquals(
            $this->orderProducts[0]->category,
            $this->orderProducts[0]::$categories[$this->orderProducts[0]->type]
        );
    }
}
