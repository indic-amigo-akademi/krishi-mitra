<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approval;
use App\Helpers\Notiflix;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function seller_form()
    {
        return view('seller.form');
    }

    public function index()
    {
        $usr = Seller::where('user_id', Auth::id())->get()[0];
        $email = User::find(Auth::id())->email;
        $phone = User::find(Auth::id())->phone;
        Log::info('PP' . $usr . $email);
        $data = ['usr' => $usr, 'email' => $email, 'phone' => $phone];
        return view('seller.dashboard')->with($data);
    }

    protected function create_seller(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            // 'gstin' => 'string|size:15',
            'aadhaar' => 'required|string|size:12',
            'trade_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/seller/register')
                ->withErrors($validator)
                ->withInput();
        }

        Seller::create([
            'name' => $req['name'],
            'gstin' => $req['gstin'],
            'aadhaar' => $req['aadhaar'],
            'trade_name' => $req['trade_name'],
            'user_id' => Auth::id(),
        ]);
        Approval::create([
            'user_id' => Auth::id(),
            'type' => 'seller_approval',
        ]);

        return redirect('/home')->with(
            'alert',
            Notiflix::make([
                'code' => 'success',
                'title' => 'Yippee!',
                'type' => 'Report',
                'subtitle' => 'Your registration as a seller is in progress!',
            ])
        );
    }

    public function product_show(Request $req, $slug)
    {
        if (!Auth::user()->is_seller) {
            abort(403);
        }
        $prod = Product::where(['slug' => $slug])->first();
        return view('seller.product.show')->with('product', $prod);
    }

    public function product_ordered()
    {
        if (!Auth::user()->is_seller) {
            abort(403);
        }
        $x = Seller::where('user_id', Auth::user()->id)->get()[0];
        $products = DB::table('orders')
            ->select(DB::raw('product_id as id,sum(qty) as qty,max(name)as name,sum(orders.price) as price'))
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->where('products.seller_id', $x->id)
            ->groupBy('product_id')
            // ->having('products.seller_id', $x->id)
            ->get()->toArray();
        log::info('The orders for this seller are');
        //var_dump($products[0]);
        return view('seller.orders')->with('products', $products);
    }

    public function product_display()
    {
        if (!Auth::user()->is_seller) {
            abort(403);
        }
        $sid = Seller::where('user_id', Auth::id())->get()[0]->id;
        $products = Product::where('seller_id', $sid)->get();
        Log::info('Nimish' . $products . $sid);
        return view('seller.product.list')->with('products', $products);
    }
}
