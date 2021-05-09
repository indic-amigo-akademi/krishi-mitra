<?php

namespace App\Http\Controllers;

use App\Seller;
use App\User;
use App\Product;
use App\Cart;
use App\Address;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Image;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('Checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        LOG::info('REQ IS' . $req);
        if (Address::where('user_id', Auth::id())->count() == 0) {
            Address::create([
                'user_id' => Auth::id(),
                'type' => $req['type'],
                'street' => $req['street'],
                'house_no' => $req['house_no'],
                'city' => $req['city'],
                'state' => $req['state'],
                'pincode' => $req['pincode'],
                'landmark' => $req['landmark']
            ]);
        }
        if ($req['optradio'] == 'COD') {
            return redirect(route('OrderProcessed.cod'));
        } else {
            return view('CardDetails');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storecod(Request $request)
    {
        $products = Cart::where('user_id', Auth::id())->get();
        $oid = rand(1, 999999999);
        foreach ($products as $p) {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $p->product_id,
                'order_id' => $oid,
                'qty' => $p->qty,
                'price' => $p->qty * $p->price * (1 - $p->discount),
                'discount' => $p->discount,
                'status' => 'Processed',
                'type' => 'cod',
            ]);
            Cart::find($p->id)->delete();
        }
        log::info('ORDER PROCESSED SUCCESSFULLY');
        return redirect(route('home'));
    }
    public function storecard(Request $request)
    {
        log::info($request);
        log::info('PROPERTY EXISTS' . property_exists($request, 'card'));
        $products = Cart::where('user_id', Auth::id())->get();
        $oid = rand(1, 999999999);
        foreach ($products as $p) {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $p->product_id,
                'order_id' => $oid,
                'qty' => $p->qty,
                'price' => $p->qty * $p->price * (1 - $p->discount),
                'discount' => $p->discount,
                'status' => 'Processed',
                'type' => 'card',
            ]);
            Cart::find($p->id)->delete();
        }
        log::info('ORDER PROCESSED SUCCESSFULLY');
        return redirect(route('home'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
