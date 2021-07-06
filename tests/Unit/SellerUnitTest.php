<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Seller;
use App\User;

class SellerUnitTest extends TestCase
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
        $this->seller=new Seller();
    }
    
     public function testFillableAttributes()
    {
        $fillable = ['name', 'user_id', 'gstin', 'aadhaar', 'trade_name'];

        $this->assertEquals($this->seller->getFillable(), $fillable);
    }
    public function test_seller_belongsto_user()
    {
     
        $seller=new Seller();
        $this->assertEquals($seller->user_id, $this->user->id);
       
    }
}
