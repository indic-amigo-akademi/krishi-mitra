<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Cart;
use App\Product;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class CartUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = new Cart();
       $this->user=new User();
       $this->product=new Product();
        
    }



    public function testFillableAttributes()
    {
        $fillable = [ 'user_id', 'product_id', 'qty', 'price', 'discount'];

        $this->assertEquals($this->cart->getFillable(), $fillable);
    }

    public function test_cart_belongsto_user()
    {
        $cart=new Cart();
        $this->assertEquals($cart->user_id, $this->user->id);
    }
    public function test_product_belongsto_user()
    {
        $cart=new Cart();
        $this->assertEquals($cart->product_id, $this->product->id);
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
        $model->price = 10; 
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
