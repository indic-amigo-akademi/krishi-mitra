<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class SellerUnitTest extends TestCase
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
        $fillable = ['name', 'user_id', 'gstin', 'aadhaar', 'trade_name'];
        $this->assertEquals($this->users[1]->seller->getFillable(), $fillable);
    }

    public function testSellerBelongsToUser()
    {
        $this->assertEquals($this->users[1]->seller->user->id, $this->users[1]->id);
    }

    public function testSellerBelongsToProducts()
    {
        $this->assertEquals($this->users[1]->seller->products[0]->id, $this->products[0]->id);
    }
}
