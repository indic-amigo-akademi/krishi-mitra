<?php

namespace Tests\Unit;

use App\Models\FileImage;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    use RefreshDatabase;

    private $user, $product, $sellerUser, $seller, $fileimage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->sellerUser = User::factory()->seller()->create();
        $this->seller = Seller::factory()->create(['user_id' => $this->sellerUser->id]);
        $this->product = Product::factory()->create(['seller_id' => $this->seller->id]);
        // $this->fileimage = FileImage::factory()->create();
    }

    public function testFillableAttributes()
    {
        $fillable = [
            'type',
            'seller_id',
            'desc',
            'price',
            'name',
            'unit',
            'quantity',
            'slug',
            'discount',
            'active',
        ];

        $this->assertEquals($this->product->getFillable(), $fillable);
    }

    public function testProductBelongstoSeller()
    {
        $this->assertEquals(
            $this->product->seller->id,
            $this->seller->id
        );
    }

    public function testProductHasManyCoverPhotos()
    {
        $coverphotos[] = FileImage::factory()->create([
            'type' => 'products',
            'ref_id' => $this->product->id
        ]);
        $coverphotos[] = FileImage::factory()->create([
            'type' => 'products', 'ref_id' => $this->product->id
        ]);
        $coverphotos = collect($coverphotos);

        $this->assertCount(
            2,
            $this->product->coverPhotos
        );

        $this->assertEquals(
            $this->product->coverPhotos->pluck('id'),
            $coverphotos->pluck('id')
        );
    }

    public function testGetPriceAfterDiscountWithDiscount()
    {
        $this->assertEquals(
            $this->product->discountedPrice,
            $this->product->price * (1 - $this->product->discount)
        );
    }

    public function testGetCategory()
    {
        $this->assertEquals(
            $this->product->category,
            $this->product::$categories[$this->product->type]
        );
    }

    public function testGetProductUnit()
    {
        $this->assertEquals(
            $this->product->productUnit,
            $this->product::$units[$this->product->unit]
        );
    }
}
