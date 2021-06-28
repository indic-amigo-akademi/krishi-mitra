<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Product;
use PHPUnit\Framework\TestCase;

class Testproduct extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    use DatabaseMigrations;
    use DatabaseTransactions;

    private $product;

	public function setUp(): void {
		parent::setUp();
		$this->store =['id' => 3,
        'type' => 'Vegetable',
        'seller_id' => 2,
        'desc' => '<p>This is a potato<p>',
        'price' => 15,
        'name' => 'Aloo Jyoti',
        'unit' => 'KGS',
        'quantity' => '133',
        'slug' => 'aloo_jyoti',
        'discount' => 0.3,] ;
	}

    /**
     * A basic unit test set price after discount.
     *
     * @return void
     */
    public function testgetPriceAfterDiscountWithDiscount()
    {
    	$model = new Product();
    	$model->price = 10;
    	
    	$model->discount = 0.3;
        $output = $model->getDiscountedPriceAttribute($model);
    	$expect = new Product();
    	$expect->price = 10;
    	
    	$expect->discount = 0.3;
        $expect1 = $expect->price * $expect->discount;
        $this->assertEquals($expect1, $output);
    }
   

}
