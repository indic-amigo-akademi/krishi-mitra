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
use Illuminate\Support\Facades\DB;

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
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

        $products = Product::all();
        return view('seller.product.list')->with('products', $products);
    }
    public function search(Request $req)
    {
        log::info('Purcho' . $req['search']);
        $x = $req['search'];
        $products = Product::where('name', 'like', '%' . $x . '%')->get();
        log::info('Products are:-' . $products);
        if (count($products) == 0) {
            $sid = Seller::where('name', '=', $x)->get();
            if (count($sid) > 0) {
                $products = Product::where('seller_id', '=', $sid[0]->id)->get();
            }
        }
        if (count($products) == 0) {
            $products = Product::where('desc', 'like', '%' . $x . '%')->get();
        }
        return view('product.search')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }
        return view('seller.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

        $fileName = [];

        $product = Product::create([
            'type' => $req['type'],
            'desc' => $req['desc'],
            'price' => $req['price'],
            'quantity' => $req['quantity'],
            'name' => $req['name'],
            'unit' => $req['unit'],
            'seller_id' => Auth::user()->seller->id,
            'slug' => Str::slug($req['name'], '_'),
            'discount' => $req['discount'],
        ]);
        log::info('This method store is called');

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
                    'ref_id' => $product->id,
                ]);
                array_push($fileName, $img->id);
            }
        }
        return redirect(route(Auth::user()->role . '.product.browse'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

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
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

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
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

        /*if (User::find(Auth::id())->role == 'seller') {
            Log::info('Seller');
            $sid = Auth::user()->seller->id;
            $psid = Product::find($id)->seller_id;
            log::info('Sid and Psid are' . $sid . ' ' . $psid);
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }*/

        $prod = Product::find($id);
        $prod->name = $req->name;
        $prod->type = $req->type;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->discount = $req->discount;
        $prod->save();
        log::info('Type of user is' . Auth::user()->role);
        return redirect(route(Auth::user()->role . '.product.browse'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
            abort(403);
        }

        if (Auth::user()->is_seller) {
            $sid = Auth::user()->seller->id;
            $psid = Product::find($id)->seller_id;
            if ($sid != $psid) {
                log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        Product::find($id)->delete();

        return redirect(route(Auth::user()->role . '.product.browse'));
    }
    public function inactivate($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        DB::table('products')
            ->where('id', $id)
            ->update(['active' => 0]);

        return redirect('/admin/product/browse');
    }
    public function activate($id)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        DB::table('products')
            ->where('id', $id)
            ->update(['active' => 1]);

        return redirect('/admin/product/browse');
    }
}
