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
            $role = USER::find(['id' => Auth::id()])[0]->role;
        }
        log::info('Role is' . $role);
        return view('seller.product_list')->with('products', $products);
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
            return view('seller.product_create');
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
                var_dump($image->name());
                $imageName =
                    $image->getClientOriginalName() +
                    time() +
                    '.' +
                    $image->extension();
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
            'cover' => join(',', $fileName),
            'name' => $req['name'],
            'unit' => $req['unit'],
            'seller_id' => Auth::id(),
            'slug' => Str::slug($req['name'], '_'),
            'discount' => $req['discount'],
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
        log::info('The product info is' . $prod);
        Log::info('HELO The id of the product to be edited is ' . $id);
        return view('seller.product_edit')->with('product', $prod);
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
        if (User::find(Auth::id())->role == 'seller') {
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
