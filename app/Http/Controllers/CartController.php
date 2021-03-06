<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart_products = Cart::where('user_id', Auth::id())->get();
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('profile.cart', compact('cart_products', 'addresses'));
    } // test done

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        log::info('Request id is ' . $req->input('id'));
        $prod_id = $req->input('id');
        $user_id = Auth::id();
        $prod = Product::find($prod_id);
        $c = Cart::where([
            ['product_id', '=', $prod_id],
            ['user_id', '=', Auth::id()],
        ])->count();
        if ($c == 0) {
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $prod_id,
                'qty' => 1,
                'price' => $prod->price,
                'discount' => $prod->discount,
            ]);
        } else {
            $cart_prod = Cart::where([
                ['product_id', '=', $prod_id],
                ['user_id', '=', Auth::id()],
            ])->get()[0];
            log::info('CART PRODUCT' . $cart_prod);
            $cart_prod->qty = $cart_prod->qty + 1;
            $cart_prod->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function incr(Request $req)
    {
        $prod = Cart::find($req->input('id'));
        log::info('INCREMENT' . $prod);
        $prod->qty = $prod->qty + 1;
        $prod->save();
    }
    public function decr(Request $req)
    {
        $prod = Cart::find($req->input('id'));
        if ($prod->qty == 1) {
            Cart::find($req->input('id'))->delete();
        } else {
            $prod->qty = $prod->qty - 1;
            $prod->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {
        Cart::find($req->input('id'))->delete();
        LOG::info('Product Is Destroyed');
        $cart_array = Cart::where('user_id', Auth::id())->get();
        $final_array = [];
        foreach ($cart_array as $item) {
            $item['type'] = Product::find($item->product_id)->type;
            $item['cover'] = Product::find($item->product_id)->cover;
            array_push($final_array, $item);
        }
        log::info('Final Array', $final_array);
        return view('profile.cart')->with('products', $final_array);
    }
}
