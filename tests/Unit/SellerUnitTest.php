<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerUnitTest extends TestCase
{
    use RefreshDatabase;

    private $user, $seller, $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->seller = Seller::factory()->create(['user_id' => $this->user->id]);
        $this->product = Product::factory()->create(['seller_id' => $this->seller->id]);
    }

    public function testFillableAttributes()
    {
        $fillable = ['name', 'user_id', 'gstin', 'aadhaar', 'trade_name'];
        $this->assertEquals($this->seller->getFillable(), $fillable);
    }
    
    public function testSellerBelongsToUser()
    {
        $this->assertEquals($this->seller->user->id, $this->user->id);
    }
    
    public function testSellerBelongsToProducts()
    {
        $this->assertEquals($this->seller->products[0]->id, $this->product->id);
    }
}
