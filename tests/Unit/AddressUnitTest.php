<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class AddressUnitTest extends TestCase
{
    use RefreshDatabase, SetupTest;
    private Collection $users;
    private Collection $addresses;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpAddresses();
    }

    public function testFillableAttributes()
    {
        $fillable = [
            'user_id',
            'name',
            'mobile',
            'address1',
            'address2',
            'city',
            'state',
            'pincode',
            'landmark',
            'type',
        ];

        $this->assertEquals($this->addresses[0]->getFillable(), $fillable);
    }

    public function testAddressBelongstoUser()
    {
        $address = Address::factory()->make([
            'user_id' => $this->users[0]->id
        ]);
        $this->assertEquals($address->user->id, $this->users[0]->id);
    }

    public function testGetAddressAttribute()
    {
        $address1 = Address::factory()->make();
        $address1->address1 = 'central road';
        $address1->address2 = 'abc';
        $address1->city = 'kolkata';
        $address1->pincode = 700028;
        $address1->landmark = 'telephone exchange';
        $received = $address1->full_address;

        $address2 = Address::factory()->make();
        $address2->address1 = 'central road';
        $address2->address2 = 'abc';
        $address2->city = 'kolkata';
        $address2->pincode = 700028;
        $address2->landmark = 'telephone exchange';
        $expected = $address2->address1 .
            ', ' .
            $address2->address2 .
            ($address2->city ? ', ' . $address2->city : '') .
            ($address2->pincode ? '-' . $address2->pincode : '') .
            ($address2->landmark ? ', ' . $address2->landmark : '');

        $this->assertEquals($received, $expected);
    }
}
