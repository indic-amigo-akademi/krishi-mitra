<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Order;
use App\User;
use App\Product;
use App\Address;
class OrderUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
        $this ->product=new Product();
        $this->address=new Address();
         $this->order=new Order();
    }
    
     public function testFillableAttributes()
    {
        $fillable = ['user_id',
        'product_id',
        'address_id',
        'order_id',
        'qty',
        'price',
        'discount',
        'status',
        'type',];

        $this->assertEquals($this->order->getFillable(), $fillable);
    }

    public function test_order_belongsto_user()
    {
     
        $order=new Order();
        $this->assertEquals($order->user_id, $this->user->id);
       
    }
    public function test_order_belongsto_product()
    {
        $order=new Order();
        $this->assertEquals($order->product_id, $this->product->id);
       
    }
    public function test_order_belongsto_address()
    {
        
        $order=new Order();
        $this->assertEquals($order->address_id, $this->address->id);
    }
    public function test_get_Discounted_PriceAttribute()
    {
        
        $model = new Order();
        $model->price = 10;

        $model->discount = 0.3;
        $output = $model->getDiscountedPriceAttribute($model);
        $expect = new Order();
        $expect->price = 10;

        $expect->discount = 0.3;
        $expect1 = $expect->price * (1 - $expect->discount);
        $this->assertEquals($expect1, $output);
    }
    public function test_get_Total_PriceAttribute()
    {
        //$this->price * $this->qty
        $model = new Order();
        $model->price = 10;

        $model->qty = 2;
        $output = $model->getTotalPriceAttribute($model);
        $expect = new Order();
        $expect->price = 10;

        $expect->qty = 2;
        $expect1 = $expect->price * $expect->qty;
        $this->assertEquals($expect1, $output);
    }

    public function test_get_TotalDiscountedPriceAttribute()
    {
       // $this->price * (1 - $this->discount) * $this->qty;
         $model = new Order();
         $model->price = 10;
         $model->discount = 0.3;
         $model->qty = 2;
         $output = $model->getTotalDiscountedPriceAttribute($model);
         $expect = new Order();
         $expect->price = 10;
 
         $expect->discount = 0.3;
         $expect->qty = 2;
         $expect1 = $expect->price * (1 - $expect->discount) * $expect->qty;
         $this->assertEquals($expect1, $output);
    }
}
