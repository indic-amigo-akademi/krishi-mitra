<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class CartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithoutMiddleware, RefreshDatabase, SetupTest;
    private Collection $users;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpUsers();
        $this->setUpProducts();
        $this->setUpCartProducts();
    }

    public function test_cart_store()
    {
        $req = ['id' => 1];
        $this->actingAs($this->users[1])->post(route('cart.store'), $req);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->product_id, $req['id']);
    }

    public function test_cart_incr()
    {
        $cartProduct = Cart::where('product_id', 1)->first();
        $data = ['id' => $cartProduct->id];
        $this->actingAs($this->users[1])->post(route('cart.increment'), $data);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->id, $data['id']);
        $this->assertEquals($lastProduct->qty, $cartProduct->qty + 1);
    }
    public function test_cart_decr()
    {
        $cartProduct = Cart::where('product_id', 1)->first();
        $data = ['id' => $cartProduct->id];
        $this->actingAs($this->users[1])->post(route('cart.decrement'), $data);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->id, $data['id']);
        $this->assertEquals($lastProduct->qty, $cartProduct->qty  - 1);
    }
    public function test_cart_destroy()
    {
        $cartProduct = Cart::where('product_id', 1)->first();
        $data = ['id' => $cartProduct->id];
        $this->actingAs($this->users[1])->post(route('cart.delete'), $data);
        $lastProduct = count(Cart::where('id', $data['id'])->get());
        $this->assertEquals($lastProduct, 0);
    }
}
