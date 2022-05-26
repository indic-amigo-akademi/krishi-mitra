<?php

namespace Tests\Unit;

use App\Address;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

use function PHPSTORM_META\type;

class AddressTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::where("id", "=", 1)->first();
        $this->admin = User::where("id", "=", 2)->first();
        $this->seller = User::where("id", "=", 11)->first();
        $this->customer = User::where("id", "=", 8)->first();
        $this->setUpFaker();
        // $this->faker->seed(1235);
    }

    public function test_add_address()
    {
        $new_address = [
            'name' => $this->faker->name(),
            'mobile' => (int) $this->faker->regexify('[1-9]{1}[0-9]{9}'),
            'address1' => $this->faker->buildingNumber(),
            'address2' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'pincode' => (int) $this->faker->postcode(),
            'landmark' => $this->faker->secondaryAddress(),
            'type' => $this->faker->randomElement(['Home', 'Work']),
            'redirect_name' => route('address')
        ];
        Log::info($new_address);
        $response = $this->actingAs($this->customer)->post(route('address.add'), $new_address);
        // print($response);
        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $new_address['name']);

        $response->assertStatus(302);
        $response->assertRedirect(route('address'));
    }

    public function test_edit_address()
    {
        $lastAddress = Address::all()->sortByDesc('updated_at')->first();
        $id = $lastAddress->id;
        $update_address = [
            'id' => $id,
            'name' => 'Rogers',
            'mobile' => (int) $this->faker->regexify('[1-9]{1}[0-9]{9}'),
            'address1' => $this->faker->buildingNumber(),
            'address2' => $this->faker->streetName(),
            'city' => 'Houston',
            'state' => $this->faker->state(),
            'pincode' => (int) $this->faker->postcode(),
            'landmark' => $this->faker->secondaryAddress(),
            'type' => $this->faker->randomElement(['Home', 'Work']),
            'redirect_name' => route('address')
        ];

        $response = $this->actingAs($this->customer)->post(route('address.edit'), $update_address);

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertEquals($lastAddress->name, $update_address['name']);


        $response->assertStatus(302);
        $response->assertRedirect(route('address'));
    }

    public function test_delete_address()
    {
        $lastAddress = Address::all()->sortByDesc('updated_at')->first();
        $id = $lastAddress->id;

        $param = ['input' => 'Delete', 'id' => $id];
        $response = $this->actingAs($this->customer)->from(route('address'))->post(route('address.edit.delete'), $param);

        $lastAddress = Address::all()->sortByDesc('updated_at')->first();

        $this->assertNotEquals($lastAddress->id, $id);

        $response->assertStatus(302);
        $response->assertRedirect(route('address'));
    }
}
