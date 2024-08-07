<?php

namespace App\Http\Controllers;

use App\Models\FileImage;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        // if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
        //     abort(403);
        // }

        $products = Product::all();
        return view('seller.product.list')->with('products', $products);
    } // test done

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!(Auth::user()->is_seller || Auth::user()->is_admin)) {
        //     abort(403);
        // }
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
            'slug' => Str::slug($req['name'], '-'),
            'discount' => $req['discount'],
        ]);
        Log::info('This method store is called');

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
                    Log::info('ERROR SAVING IMAGE');
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

    public function show_one($slug)
    {
        $product = Product::where(['slug' => $slug])->first();
        $seller = Seller::where(['id' => $product->seller_id])->first();
        return view('product', compact('product', 'seller'));
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

        $prod = Product::find($id);
        $prod->name = $req->name;
        $prod->type = $req->type;
        $prod->desc = $req->desc;
        $prod->price = $req->price;
        $prod->discount = $req->discount;
        $prod->save();
        Log::info('Type of user is' . Auth::user()->role);
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
                Log::info('You cannot delete someone else product');
                return redirect('/');
            }
        }

        Product::find($id)->delete();

        return redirect(route(Auth::user()->role . '.product.browse'));
    }

    /**
     * Deactivate the product.
     *
     * @param [type] $id
     * @return void
     */
    public function deactivate($id)
    {
        $product = Product::where('id', $id);

        // if (Auth::user()->is_seller)
        //     $product->where('seller_id', Auth::user()->seller->id);
        // else
        //     abort(404);

        if (!isset($product) || $product->count() == 0) 
            abort(404);

        // if ($product->first()->active == 0)
        //     abort(405);

        $product->update(['active' => 0]);

        return redirect(route(
            (Auth::user()->is_admin ? 'admin' : 'seller') . '.product.browse'
        ));
    }

    /**
     * Activate the product.
     *
     * @param [type] $id
     * @return void
     */
    public function activate($id)
    {
        $product = Product::where('id', $id);

        // if (Auth::user()->is_seller)
        //     $product->where('seller_id', Auth::user()->seller->id);
        // else
        //     abort(404);

        if (!isset($product) || $product->count() == 0)
            abort(404);

        // if ($product->first()->active == 1)
        //     abort(405);

        $product->update(['active' => 1]);

        return redirect(route(
            (Auth::user()->is_admin ? 'admin' : 'seller') . '.product.browse'
        ));
    }
}
