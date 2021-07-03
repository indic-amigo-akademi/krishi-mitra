<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cart;
use App\Product;
use PHPUnit\Framework\TestCase;

class CartunitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->store = [
            'user_id' => 1,
            'product_id' => 2,
            'qty' => 2,
            'price' => 10,
            'discount' => 0.3
        ];
    }

    public function testgettotalprice()
    {
        $model = new Cart();
        $model->price = 10;

        $model->qty = 2;
        $output = $model->getTotalPriceAttribute($model);
        $expect = new Cart();
        $expect->price = 10;

        $expect->qty = 2;
        $expect1 = $expect->price * $expect->qty;
        $this->assertEquals($expect1, $output);
    }
    public function testgetDiscountedPriceAttribute()
    {
        $model = new Cart();
        $model->price = 10; // $this->price * (1 - $this->discount);

        $model->discount = 0.3;
        $output = $model->getDiscountedPriceAttribute($model);
        $expect = new Cart();
        $expect->price = 10;

        $expect->discount = 0.3;
        $expect1 = $expect->price * (1 - $expect->discount);
        $this->assertEquals($expect1, $output);
    }

    public function testgetTotalDiscountedPriceAttribute()
    {
        //$this->price * (1 - $this->discount) * $this->qty
        $model = new Cart();
        $model->price = 10;
        $model->discount = 0.3;
        $model->qty = 2;
        $output = $model->getTotalDiscountedPriceAttribute($model);
        $expect = new Cart();
        $expect->price = 10;

        $expect->discount = 0.3;
        $expect->qty = 2;
        $expect1 = $expect->price * (1 - $expect->discount) * $expect->qty;
        $this->assertEquals($expect1, $output);
    }
}
