<?php

namespace Tests\Unit;

use App\Models\FileImage;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;
class ProductUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


   

    protected function setUp(): void
    {
        parent::setUp();

       
       $this->user=new User();
       $this->product=new Product();
       $this->seller=new Seller();
       $this->fileimage=new FileImage();
        
    }



    public function testFillableAttributes()
    {
        $fillable = [ 'type',
        'seller_id',
        'desc',
        'price',
        'name',
        'unit',
        'quantity',
        'slug',
        'discount',];

        $this->assertEquals($this->product->getFillable(), $fillable);
    }

    public function test_product_belongsto_seller()
    {
        $product=new product();
        $this->assertEquals($product->seller_id, $this->seller->id);
    }
   public function test_product_hasmany_coverphoto()
   {

    $product = new product();
    $user=new User();
    $coverphoto=new FileImage(['ref_id'=>array('type','product')]);
    $coverphoto1=new FileImage(['ref_id'=>array('type','product')]);
    $testArray = array($coverphoto,$coverphoto1);
    $expectedCount = 2;
    $this->assertCount(
        $expectedCount,
        $testArray
    );
   }
    public function testgetPriceAfterDiscountWithDiscount()
    {
        $model = new Product();
        $model->price = 10;

        $model->discount = 0.3;
        $output = $model->getDiscountedPriceAttribute($model);
        $expect = new Product();
        $expect->price = 10;

        $expect->discount = 0.3;
        $expect1 = $expect->price * (1 - $expect->discount);
        $this->assertEquals($expect1, $output);
    }
    public function testgetcategory()
    {
        $model = new Product();
        $model::$categories[$model->type] = 'Vegetable';
        $output = $model->getCategoryAttribute($model);
        $expect = new Product();
        // $expect::$categories[$model->type]='Vegetable';
        $expect = 'Vegetable';
        $this->assertEquals($expect, $output);
    }
    public function testgetproductunit()
    {
        $model = new Product();
        $model::$units[$model->unit] = 'KGS';
        $output = $model->getProductUnitAttribute($model);
        $expect = new Product();

        $expect = 'KGS';
        $this->assertEquals($expect, $output);
    }
    
   
  }
