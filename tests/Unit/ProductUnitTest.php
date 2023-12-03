<?php

namespace Tests\Unit;

use App\Models\FileImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class ProductUnitTest extends TestCase
{
    use RefreshDatabase, SetupTest;

    private Collection $users;
    private Collection $products;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpProducts();
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

        $this->assertEquals($this->products[0]->getFillable(), $fillable);
    }

    public function testProductBelongstoSeller()
    {
        $this->assertEquals(
            $this->products[0]->seller->id,
            $this->users[1]->seller->id
        );
    }

    public function testProductHasManyCoverPhotos()
    {
        $coverphotos[] = FileImage::factory()->create([
            'type' => 'products',
            'ref_id' => $this->products[0]->id
        ]);
        $coverphotos[] = FileImage::factory()->create([
            'type' => 'products', 'ref_id' => $this->products[0]->id
        ]);
        $coverphotos = collect($coverphotos);

        $this->assertCount(
            2,
            $this->products[0]->coverPhotos
        );

        $this->assertEquals(
            $this->products[0]->coverPhotos->pluck('id'),
            $coverphotos->pluck('id')
        );
    }

    public function testGetPriceAfterDiscountWithDiscount()
    {
        $this->assertEquals(
            $this->products[0]->discountedPrice,
            $this->products[0]->price * (1 - $this->products[0]->discount)
        );
    }

    public function testGetCategory()
    {
        $this->assertEquals(
            $this->products[0]->category,
            $this->products[0]::$categories[$this->products[0]->type]
        );
    }

    public function testGetProductUnit()
    {
        $this->assertEquals(
            $this->products[0]->productUnit,
            $this->products[0]::$units[$this->products[0]->unit]
        );
    }
}
