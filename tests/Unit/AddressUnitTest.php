<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Address;
use App\User;

class AddressUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->address = new Address();
        $this->user=new User();
        
    }



    public function testFillableAttributes()
    {
        $fillable = [ 'user_id',
        'name',
        'mobile',
        'address1',
        'address2',
        'city',
        'state',
        'pincode',
        'landmark',
        'type',];

        $this->assertEquals($this->address->getFillable(), $fillable);
    }

    public function test_address_belongsto_user()
    {
        $address=new Address();
        $this->assertEquals($address->user_id, $this->user->id);
    }
    public function test_getaddress_attribute()
    {
        $address=new Address();
        $address->address1='central road';
        $address->address2='abc';
        $address->city='kolkata';
        $address->pincode=700028;
        $address->landmark='telephone exchange';
        $output=$address->getFullAddressAttribute($address);
        $expect=new Address();
        $expect->address1='central road';
        $expect->address2='abc';
        $expect->city='kolkata';
        $expect->pincode=700028;
        $expect->landmark='telephone exchange';
        $expect1=$expect->address1 .
        ', ' .
        $expect->address2 .
        ($expect->city ? ', ' . $expect->city : '') .
        ($expect->pincode ? '-' . $expect->pincode : '') .
        ($expect->landmark ? ', ' . $expect->landmark : '');
        $this->assertEquals($output,$expect1);

    }
}
