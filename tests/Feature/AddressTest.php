<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_address()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $address = [
            'Full name' => 'srija Karmakar',
            'Mobile number' => 2345678902,
            'PIN code' => 700023,
            'Flat,House no.,building,company,apartment' => '3A',
            'Area,colony,street' => 'n.nagar',
            'Landmark' => 'abc',
            'town/city' => 'kol',
            'state/province/region' => 'west bengal'

        ];
        $response->json('POST', 'address.add', $address);

        $response->assertStatus(200);
    }
    public function test_edit_address()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);
        $address = [
            'Fullname' => 'srija Karmakar',
            'Mobile' => 2345678902,
            'PIN code' => 700023,
            'Flat,House no.,building,company,apartment' => '3A',
            'Area,colony,street' => 'n.nagar',
            'Landmark' => 'abc',
            'town/city' => 'kol',
            'state/province/region' => 'west bengal'

        ];
        $update = [
            'Fullname' => 'srija Karmakar',
            'Mobile' => 2345678902,
            'PIN code' => 700023,
            'Flat,House no.,building,company,apartment' => '3A',
            'Area,colony,street' => 'n.nagar',
            'Landmark' => 'pqr',
            'town/city' => 'kol',
            'state/province/region' => 'west bengal'
        ];
        $response->json('POST', 'address.edit', [
            $address['Fullname'], $address['Mobile'], $address['PIN code'],
            $address['Flat,House no.,building,company,apartment'], $address['Area,colony,street'], $address['Landmark'], $address['town/city'], $address['state/province/region']
        ]);

        $response->assertStatus(200);
    }
    public function test_delete_address()
    {
        $response = $this->json('POST', route('user.login.validate'), [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

     $address = [
            'Fullname' => 'srija Karmakar',
            'Mobile' => 2345678902,
            'PIN code' => 700023,
            'Flat,House no.,building,company,apartment' => '3A',
            'Area,colony,street' => 'n.nagar',
            'Landmark' => 'abc',
            'town/city' => 'kol',
            'state/province/region' => 'west bengal'

        ];

 $response->json('POST', 'address.edit.delete',$address);
 $response->assertStatus(200);
    }
}
