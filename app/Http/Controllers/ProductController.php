<?php

namespace App\Http\Controllers;

use App\FileImage;
use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Product;
use Illuminate\Support\Str;
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
            $role = Auth::user()->role;
        }
        return view('seller.product.list')->with('products', $products);
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
            return view('seller.product.create');
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
    {
        $fileName = [];
        if ($req->hasFile('cover')) {
            $destinationPath = public_path('uploads/products');
            foreach ($req->file('cover') as $image) {
                $filename = pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $extension = pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_EXTENSION
                );
                $imageName = $filename . time() . '.' . $extension;
                if (!$image->move($destinationPath, $imageName)) {
                    log::info('ERROR SAVING IMAGE');
                }
                $img = FileImage::create([
                    'name' => $imageName,
                    'type' => 'products',
                ]);
                array_push($fileName, $img->id);
            }
        }

        Product::create([
            'type' => $req['type'],
            'desc' => $req['desc'],
            'price' => $req['price'],
            'quantity' => $req['qty'],
            'name' => $req['name'],
            'unit' => $req['unit'],
            'seller_id' => Auth::user()->seller->id,
            'slug' => Str::slug($req['name'], '_'),
            'discount' => $req['discount'],
        ]);
        Log::info('Yohoo Product Created');
        return redirect('/seller/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prod = Product::find($id);
        return view('product.product')->with('product', $prod);
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
        return view('seller.product.edit')->with('product', $prod);
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
        if (User::find(Auth::id())->role == 'seller') {
            Log::info('Seller');
            $sid = Auth::user()->seller->id;
            $psid = Product::find($id)->seller_id;
            log::info('Sid and Psid are' . $sid . ' ' . $psid);
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        $prod = Product::find($id);
        $prod->name = $req->name;
        $prod->type = $req->type;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->discount = $req->discount;
        $prod->save();

        return redirect('/seller/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'seller') {
            $sid = Auth::user()->seller->id;
            $psid = Product::find($id)->seller_id;
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        Product::find($id)->delete();

        return redirect('/seller/products');
    }
}
