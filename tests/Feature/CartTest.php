<?php

namespace Tests\Feature;

use App\User;
use App\Product;
use Faker\Generator as Faker;
use App\Cart;
use App\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //use WithFaker;
    use WithoutMiddleware;
    public function setUp(): void
    {
        parent::setUp();
        $this->sysadmin = User::where("id", "=", 1)->first();
        $this->admin = User::where("id", "=", 2)->first();
        $this->seller = User::where("id", "=", 11)->first();
        $this->customer = User::where("id", "=", 8)->first();
        //$this->setUpFaker();
        // $this->faker->seed(1235);
        //->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
    }

    public function test_cart_store()
    {
        $req = ['id' => 9];
        $response = $this->actingAs($this->seller)->post(route('cart.store'), $req);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->product_id, $req['id']);
    }
    public function test_cart_incr()
    {
        $y = Cart::where('product_id', 9)->get()[0]->qty;
        $id = Cart::where('product_id', 9)->get()[0]->id;
        $req = ['id' => $id];
        log::info('The value of y is' . $y);
        $response = $this->actingAs($this->seller)->post(route('cart.increment'), $req);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->id, $req['id']);
        $this->assertEquals($lastProduct->qty, $y + 1);
    }
    public function test_cart_decr()
    {

        $y = Cart::where('product_id', 9)->get()[0]->qty;
        $id = Cart::where('product_id', 9)->get()[0]->id;
        $req = ['id' => $id];
        log::info('The value of y is' . $y);
        $response = $this->actingAs($this->seller)->post(route('cart.decrement'), $req);
        $lastProduct = Cart::all()->sortByDesc('updated_at')->first();
        log::info('Last product' . $lastProduct);
        $this->assertEquals($lastProduct->id, $req['id']);
        $this->assertEquals($lastProduct->qty, $y - 1);
    }
    public function test_cart_destroy()
    {

        $y = Cart::where('product_id', 9)->get()[0]->qty;
        $id = Cart::where('product_id', 9)->get()[0]->id;
        $req = ['id' => $id];
        log::info('The value of y is' . $y);
        $response = $this->actingAs($this->seller)->post(route('cart.destroy'), $req);
        $lastProduct = count(Cart::where('id', $id)->get());
        $this->assertEquals($lastProduct, 0);
    }
}
