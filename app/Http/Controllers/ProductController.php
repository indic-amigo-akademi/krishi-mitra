<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        $role = '';
        if (Auth::id() == null) {
            $role = 'browser';
        } else {
            $role = USER::find(['id' => Auth::id()])[0]->role;
        }
        log::info('Role is' . $role);
        return view('Products')->with('data_arr', [$products, $role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $x = User::find(Auth::id());
        if ($x->role == 'seller' || $x->role == 'admin') {
            return view('CreateProduct');
        } else {
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {   log::info('PRODUCT STORAGE');
        $sid = Seller::where('user_id',Auth::id())->get()[0];
        // $sid=Seller::find(['user_id' => Auth::id()])[0];
        Log::info($sid->user_id);
        $image = $req->file('input_img');
        log::info('The image is' . $image);

        if ($req->hasFile('input_img')) {
            log::info('The IMAGE IS PRESENT');
            $image = $req->file('input_img');
            $destinationPath = public_path('\uploads\products');
            if (!$image->move($destinationPath, $image->getClientOriginalName())) {
                log::info('ERROR SAVING IMAGE');
            }
            log::info('image saved!!');
        }

        Product::create([
            'type' => $req['type'],
            'desc' => $req['desc'],
            'price' => $req['price'],
            'cover' => $image->getClientOriginalName(),
            'name' => $req['name'],
            'unit' => $req['unit'],
            'seller_id' => $sid->id,
            'slug' => $req['name'] . $sid->id,
            'discount' => 0.4,
        ]);
        LOG::info('Yohoo Product Created');
        return redirect('/');
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
        $prod = Product::find($id);
        log::info('The product info is' . $prod);
        Log::info('HELO The id of the product to be edited is ' . $id);
        return view('product_edit')->with('prod', $prod);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        Log::info('Seller');
        if (User::find(Auth::id())->role == "seller") {
            Log::info('Seller');
            $sid = Seller::find(['user_id' => Auth::id()])[0]->id;
            $psid = Product::find($id)->seller_id;
            log::info('Sid and Psid are' . $sid . ' ' . $psid);
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        $prod = Product::find($id);
        log::info($req);
        $prod->type = $req->type;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->discount = $req->discount;
        $prod->save();
        $products = Product::all();
        $role = User::find(Auth::id())->role;
        return view('Products')->with('data_arr', [$products, $role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::find(Auth::id())->role == "seller") {
            $sid = Seller::find(['user_id' => Auth::id()])[0]->id;
            $psid = Product::find($id)->seller_id;
            log::info('Sid and Psid are' . $sid . ' ' . $psid);
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        Product::find($id)->delete();
        $products = Product::all();
        $role = User::find(Auth::id())->role;
        return view('Products')->with('data_arr', [$products, $role]);
    }
}
