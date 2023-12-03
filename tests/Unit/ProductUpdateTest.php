<?php

namespace Tests\Unit;

use App\Models\FileImage;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\Traits\SetupTest;

class ProductUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase, WithFaker, SetupTest;
    
    private Collection $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->setUpUsers();
        $this->setUpProducts();
    }

    public function testCreateProduct()
    {
        $file = UploadedFile::fake()->image('R.jpg');
        // $path = '/home/andre/Desktop/usc_trojan_tommy_trojan_statue.jpg';
        // $file = new UploadedFile(
        //     $path,
        //     'usc_trojan_tommy_trojan_statue.jpg',
        //     'image/jpeg',
        //     null,
        //     true
        // );
        Log::info($file);
        $product = [
            'type' => 0,
            'seller_id' => 3,
            'desc' => '<p>This is a pineapple</p>',
            'price' => 10,
            'name' => 'Pineapple',
            'unit' => 'KGS',
            'quantity' => '133',
            'discount' => 0.4,
            'cover' => [0 => $file]
        ];

        $response = $this->actingAs($this->users[1])->post(route('product.store'), $product);
        $lastProduct = Product::all()->sortByDesc('id')->first();

        $this->assertEquals($lastProduct->name, $product['name']);
        $response->assertStatus(302);
        $response->assertRedirect(route(Auth::user()->role . '.product.browse'));
        // $file->move('/home/andre/Desktop/', 'usc_trojan_tommy_trojan_statue' . time() . '.jpg');
    }

    public function testupdateProduct()
    {
        $lastProduct = Product::all()->sortByDesc('id')->first();
        $product = [
            'type' => 1,
            'seller_id' => 3,
            'desc' => '<p>This is a pineapple fruit</p>',
            'price' => 10,
            'name' => 'Pineapple',
            'unit' => 'KGS',
            'quantity' => '133',
            'discount' => 0.4
        ];
        $response = $this->actingAs($this->users[1])->post(route('product.update', $lastProduct->id), $product);

        $lastProduct = Product::all()->sortByDesc('id')->first();
        $this->assertEquals($lastProduct->desc, $product['desc']);
        $response->assertStatus(302);
        $response->assertRedirect(route(Auth::user()->role . '.product.browse'));
    }

    public function testDeleteProduct()
    {
        $lastProduct = Product::all()->sortByDesc('id')->first();
        $id = $lastProduct->id;
        $response = $this->actingAs($this->users[1])->post(route('product.destroy', $lastProduct->id));

        $lastProduct = Product::all()->sortByDesc('id')->first();
        $this->assertNotEquals($lastProduct->id, $id);
        $response->assertStatus(302);
        $response->assertRedirect(route(Auth::user()->role . '.product.browse'));
    }
}
