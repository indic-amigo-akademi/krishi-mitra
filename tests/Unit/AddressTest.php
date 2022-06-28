<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;

use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::factory()->sysadmin()->create();
        $this->admin = User::factory()->admin()->create();
        $this->seller = User::factory()->seller()->create();
        $this->customer = User::factory()->create();
    }

    protected function createAddressSetUp()
    {
        return Address::factory()->create([
            'user_id' => $this->customer->id
        ]);
    }

    /**
     * Test if the user can add the address with valid data.
     *
     * @return void
     */
    public function testAddAddressPostRouteAsGuest()
    {
        $redirectUri = route('login');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();
    }

    /**
     * Test if the user can add the address with valid data.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithValidData()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri);

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $new_address['name']);
        $this->assertEquals($lastAddress->mobile, $new_address['mobile']);
        $this->assertEquals($lastAddress->address1, $new_address['address1']);
        $this->assertEquals($lastAddress->address2, $new_address['address2']);
        $this->assertEquals($lastAddress->city, $new_address['city']);
        $this->assertEquals($lastAddress->state, $new_address['state']);
        $this->assertEquals($lastAddress->pincode, $new_address['pincode']);
        $this->assertEquals($lastAddress->landmark, $new_address['landmark']);
        $this->assertEquals($lastAddress->type, $new_address['type']);
    }

    /**
     * Test if the user can add the address with different redirect uri.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithDifferentRedirectUri()
    {
        $redirectUri = route('home');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $new_address['name']);
        $this->assertEquals($lastAddress->mobile, $new_address['mobile']);
        $this->assertEquals($lastAddress->address1, $new_address['address1']);
        $this->assertEquals($lastAddress->address2, $new_address['address2']);
        $this->assertEquals($lastAddress->city, $new_address['city']);
        $this->assertEquals($lastAddress->state, $new_address['state']);
        $this->assertEquals($lastAddress->pincode, $new_address['pincode']);
        $this->assertEquals($lastAddress->landmark, $new_address['landmark']);
        $this->assertEquals($lastAddress->type, $new_address['type']);
    }

    /**
     * Test if the user can add the address with no redirect uri.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoRedirectUri()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $new_address['name']);
        $this->assertEquals($lastAddress->mobile, $new_address['mobile']);
        $this->assertEquals($lastAddress->address1, $new_address['address1']);
        $this->assertEquals($lastAddress->address2, $new_address['address2']);
        $this->assertEquals($lastAddress->city, $new_address['city']);
        $this->assertEquals($lastAddress->state, $new_address['state']);
        $this->assertEquals($lastAddress->pincode, $new_address['pincode']);
        $this->assertEquals($lastAddress->landmark, $new_address['landmark']);
        $this->assertEquals($lastAddress->type, $new_address['type']);
    }

    /**
     * Test if the user can add the address with no name.
     * 
     * @return void
     */
    public function testAddAddressPostRouteWithNoName()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('name'), 'The name field is required.');
    }

    /**
     * Test if the user can add the address with name longer than 255 character.
     * 
     * @return void
     */
    public function testAddAddressPostRouteWithNameLongerThan_255Characters()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => str_repeat('a', 256),
            'mobile' => $new_address->mobile,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('name'), 'The name cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can add the address with no mobile.
     * 
     * @return void
     */
    public function testAddAddressPostRouteWithNoMobile()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile field is required.');
    }

    /**
     * Test if the user can add the address with mobile longer than 10 characters.
     * 
     * @return void
     */
    public function testAddAddressPostRouteWithMobileLongerThan_10Characters()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => (int)str_repeat('9', 11),
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile must have 10 digits.');
    }

    /**
     * Test if the user can add the address with mobile shorter than 10 characters.
     * 
     * @return void
     */
    public function testAddAddressPostRouteWithMobileShorterThan_10Characters()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'mobile' => (int)str_repeat('9', 8),
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile must have 10 digits.');
    }

    /**
     * Test if the user can add the address with no address1.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoAddress1()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address1'), 'The address1 field is required.');
    }

    /**
     * Test if the user can add the address with address 1 longer than 255.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithAddress1LongerThan_255()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => str_repeat('a', 256),
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address1'), 'The address1 cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can add the address with no address2.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoAddress2()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address2'), 'The address2 field is required.');
    }


    /**
     * Test if the user can add the address with address2 longer than 255.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithAddress2LongerThan_255()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => str_repeat('a', 256),
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address2'), 'The address2 cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can add the address with no city.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoCity()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('city'), 'The city field is required.');
    }


    /**
     * Test if the user can add the address with city longer than 255.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithCityLongerThan_255()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => str_repeat('a', 256),
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('city'), 'The city cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can add the address with no state.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoState()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('state'), 'The state field is required.');
    }


    /**
     * Test if the user can add the address with state longer than 255.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithStateLongerThan_255()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => str_repeat('a', 256),
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('state'), 'The state cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can add the address with no pincode.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoPincode()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('pincode'), 'The pincode field is required.');
    }

    /**
     * Test if the user can add the address with pincode longer than 6.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithPincodeLongerThan_6()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => str_repeat('4', 7),
            'landmark' => $new_address->landmark,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('pincode'), 'The pincode must have 6 digits.');
    }

    /**
     * Test if the user can add the address with no landmark.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoLandmark()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('landmark'), 'The landmark field is required.');
    }

    /**
     * Test if the user can add the address with landmark longer than 255.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithLandmarkLongerThan_255()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => str_repeat('a', 256),
            'type' => $new_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('landmark'), 'The landmark cannot be greater than 255 characters.');
    }


    /**
     * Test if the user can add the address with no type.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithNoType()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('type'), 'The type field is required.');
    }

    /**
     * Test if the user can add the address with invalid type.
     *
     * @return void
     */
    public function testAddAddressPostRouteWithInvalidType()
    {
        $redirectUri = route('address');
        $new_address = Address::factory()->make();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.add'), [
            'name' => $new_address->name,
            'address1' => $new_address->address1,
            'address2' => $new_address->address2,
            'city' => $new_address->city,
            'state' => $new_address->state,
            'pincode' => $new_address->pincode,
            'landmark' => $new_address->landmark,
            'type' => "invalid",
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('type'), 'The selected type is invalid.');
    }

    /**
     * Test if the user can edit route with valid data.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithValidData()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $city = $this->faker->city;
        $state = $this->faker->state;

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'mobile' => $updated_address->mobile,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $city,
            'state' => $state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $updated_address->name);
        $this->assertEquals($lastAddress->mobile, $updated_address->mobile);
        $this->assertEquals($lastAddress->address1, $updated_address->address1);
        $this->assertEquals($lastAddress->address2, $updated_address->address2);
        $this->assertEquals($lastAddress->city, $city);
        $this->assertEquals($lastAddress->state, $state);
        $this->assertEquals($lastAddress->pincode, $updated_address->pincode);
        $this->assertEquals($lastAddress->landmark, $updated_address->landmark);
        $this->assertEquals($lastAddress->type, $updated_address->type);
    }

    /**
     * Test if the user can edit route with no redirect uri.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithNoRedirectUri()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $city = $this->faker->city;
        $state = $this->faker->state;

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'mobile' => $updated_address->mobile,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $city,
            'state' => $state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $updated_address->name);
        $this->assertEquals($lastAddress->mobile, $updated_address->mobile);
        $this->assertEquals($lastAddress->address1, $updated_address->address1);
        $this->assertEquals($lastAddress->address2, $updated_address->address2);
        $this->assertEquals($lastAddress->city, $city);
        $this->assertEquals($lastAddress->state, $state);
        $this->assertEquals($lastAddress->pincode, $updated_address->pincode);
        $this->assertEquals($lastAddress->landmark, $updated_address->landmark);
        $this->assertEquals($lastAddress->type, $updated_address->type);
    }

    /**
     * Test if the user can edit route with no name.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithNoName()
    {

        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $city = $this->faker->city;
        $state = $this->faker->state;

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'mobile' => $updated_address->mobile,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $city,
            'state' => $state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('name'), 'The name field is required.');
    }

    /**
     * Test if the user can edit the address with name longer than 255 character.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithNameLongerThan_255Characters()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => str_repeat('a', 256),
            'mobile' => $updated_address->mobile,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('name'), 'The name cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can edit the address with no mobile.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithNoMobile()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile field is required.');
    }

    /**
     * Test if the user can edit the address with mobile longer than 10 characters.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithMobileLongerThan_10Characters()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'mobile' => (int)str_repeat('9', 11),
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile must have 10 digits.');
    }

    /**
     * Test if the user can edit the address with mobile shorter than 10 characters.
     * 
     * @return void
     */
    public function testEditAddressPostRouteWithMobileShorterThan_10Characters()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'mobile' => (int)str_repeat('9', 8),
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('mobile'), 'The mobile must have 10 digits.');
    }

    /**
     * Test if the user can edit the address with no address1.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoAddress1()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address1'), 'The address1 field is required.');
    }

    /**
     * Test if the user can edit the address with address 1 longer than 255.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithAddress1LongerThan_255()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => str_repeat('a', 256),
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address1'), 'The address1 cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can edit the address with no address2.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoAddress2()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address2'), 'The address2 field is required.');
    }


    /**
     * Test if the user can edit the address with address2 longer than 255.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithAddress2LongerThan_255()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => str_repeat('a', 256),
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('address2'), 'The address2 cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can edit the address with no city.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoCity()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('city'), 'The city field is required.');
    }


    /**
     * Test if the user can edit the address with city longer than 255.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithCityLongerThan_255()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => str_repeat('a', 256),
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('city'), 'The city cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can edit the address with no state.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoState()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('state'), 'The state field is required.');
    }


    /**
     * Test if the user can edit the address with state longer than 255.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithStateLongerThan_255()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => str_repeat('a', 256),
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('state'), 'The state cannot be greater than 255 characters.');
    }

    /**
     * Test if the user can edit the address with no pincode.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoPincode()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('pincode'), 'The pincode field is required.');
    }

    /**
     * Test if the user can edit the address with pincode longer than 6.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithPincodeLongerThan_6()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => str_repeat('4', 7),
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('pincode'), 'The pincode must have 6 digits.');
    }

    /**
     * Test if the user can edit the address with no landmark.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoLandmark()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('landmark'), 'The landmark field is required.');
    }

    /**
     * Test if the user can edit the address with landmark longer than 255.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithLandmarkLongerThan_255()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => str_repeat('a', 256),
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('landmark'), 'The landmark cannot be greater than 255 characters.');
    }


    /**
     * Test if the user can edit the address with no type.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithNoType()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();


        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('type'), 'The type field is required.');
    }

    /**
     * Test if the user can edit the address with invalid type.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithInvalidType()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => $updated_address->id,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'landmark' => $updated_address->landmark,
            'type' => "invalid",
            'redirect' => $redirectUri
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->first('type'), 'The selected type is invalid.');
    }

    /**
     * Test if the user can edit the address with invalid id.
     *
     * @return void
     */
    public function testEditAddressPostRouteWithInvalidId()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit'), [
            'id' => 42,
            'name' => $updated_address->name,
            'address1' => $updated_address->address1,
            'address2' => $updated_address->address2,
            'city' => $updated_address->city,
            'state' => $updated_address->state,
            'pincode' => $updated_address->pincode,
            'mobile' => (int)str_repeat('7', 10),
            'landmark' => $updated_address->landmark,
            'type' => $updated_address->type,
            'redirect' => $redirectUri
        ])
            ->assertStatus(404);
    }

    /**
     * Test if the user can update and delete the address with invalid id.
     *
     * @return void
     */
    public function testUpdateDeleteAddressPostWithInvalidId()
    {
        $redirectUri = route('address');
        // $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit.delete'), [
            'id' => 42,
            'type' => 'delete'
        ])
            ->assertStatus(404);
    }

    /**
     * Test if the user can update and delete the address with invalid type.
     *
     * @return void
     */
    public function testUpdateDeleteAddressPostWithInvalidType()
    {
        $updated_address = $this->createAddressSetUp();

        $this->from(route('address'))->actingAs($this->customer)->post(route('address.edit.delete'), [
            'id' => $updated_address->id,
            'type' => 'not valid'
        ])
            ->assertStatus(405);
    }

    /**
     * Test if the user can update and delete the address with valid delete data.
     *
     * @return void
     */
    public function testUpdateDeleteAddressPostWithValidDeleteData()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit.delete'), [
            'id' => $updated_address->id,
            'type' => 'delete'
        ])
            ->assertStatus(302)->assertRedirect($redirectUri)
            ->assertSessionHasNoErrors();
    }

    /**
     * Test if the user can update and delete the address with valid delete data.
     *
     * @return void
     */
    public function testUpdateDeleteAddressPostWithValidUpdateData()
    {
        $redirectUri = route('address');
        $updated_address = $this->createAddressSetUp();

        $this->from($redirectUri)->actingAs($this->customer)->post(route('address.edit.delete'), [
            'id' => $updated_address->id,
            'type' => 'edit'
        ])
            ->assertStatus(200)
            ->assertSessionHasNoErrors()
            ->assertViewHas('address', $updated_address);
    }
}
