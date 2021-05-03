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
        return view('Products')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $x = User::find(Auth::id());
        if ($x->role == 'Seller') {
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
    {
        $sid = Seller::find(['user_id' => Auth::id()])[0];
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
