<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Approval;
use App\Helpers\Notiflix;
use App\Order;
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
        if (Auth::user()->is_admin || Auth::user()->is_seller) {
            return redirect()
                ->route('home')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'info',
                        'subtitle' =>
                            'You are already registered as ' .
                            Auth::user()->role .
                            '!',
                    ])
                );
        }
        $approval = Approval::all()
            ->where('user_id', '=', Auth::id())
            ->first();
        if (isset($approval) && $approval) {
            return redirect()
                ->route('home')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'info',
                        'type' => 'Report',
                        'title' => 'Waiting!',
                        'subtitle' =>
                            'Already signed for ' .
                            str_replace('_', ' ', $approval->type) .
                            '!',
                    ])
                );
        }
        return view('seller.form');
    }

    public function index()
    {
        if (Auth::user()->role == 'customer') {
            abort(403);
        }

        if (Auth::user()->is_seller) {
            $usr = Seller::where('user_id', Auth::id())->get()[0];
            $email = User::find(Auth::id())->email;
            $phone = User::find(Auth::id())->phone;
            Log::info('PP' . $usr . $email);
            $data = ['usr' => $usr, 'email' => $email, 'phone' => $phone];
            return view('seller.dashboard')->with($data);
        }
    }

    protected function create_seller(Request $req)
    {
        // $approval = Approval::all()
        //     ->where('user_id', '=', Auth::id())
        //     ->first();
        // if (isset($approval) && $approval) {
        //     return redirect()
        //         ->route('home')
        //         ->with(
        //             'alert',
        //             Notiflix::make([
        //                 'code' => 'info',
        //                 'type' => 'Report',
        //                 'title' => 'Waiting!',
        //                 'subtitle' =>
        //                 'Already signed for ' .
        //                     str_replace('_', ' ', $approval->type) .
        //                     '!',
        //             ])
        //         );
        // }

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',

            // 'gstin' => 'string|size:15',
            'aadhaar' => 'required|string|size:12',
            'trade_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('seller.register')
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

        return redirect()
            ->route('home')
            ->with(
                'alert',
                Notiflix::make([
                    'code' => 'success',
                    'title' => 'Yippee!',
                    'type' => 'Report',
                    'subtitle' =>
                        'Your registration as a seller is in progress!',
                ])
            );
    }

    public function product_show(Request $req, $slug)
    {
        if (!Auth::user()->role == 'customer') {
            abort(403);
        }

        if (Auth::user()->is_seller) {
            $prod = Product::where(['slug' => $slug])->first();
            return view('seller.product.show')->with('product', $prod);
        }
    }

    public function product_orders()
    {
        if (!Auth::user()->is_seller) {
            abort(403);
        }
        $seller = Auth::user()->seller;
        $product_ids = Product::where('seller_id', $seller->id)
            ->pluck('id')
            ->toArray();
        $orders = Order::whereIn('product_id', $product_ids)
            ->orderBy('order_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('seller.orders')->with('orders', $orders);
    }

    public function show_one_order($id)
    {
        $seller = Auth::user()->seller;
        $product_ids = Product::where('seller_id', $seller->id)
            ->pluck('id')
            ->toArray();
        $orders = $orders = Order::whereIn('product_id', $product_ids)
            ->where('order_id', $id)
            ->get();
        if (count($orders) > 0) {
            return view('profile.order', compact('orders'));
        }
        abort(404);
    }

    public function product_display()
    {
        if (!Auth::user()->role == 'customer') {
            abort(403);
        }

        if (Auth::user()->is_seller) {
            $sid = Seller::where('user_id', Auth::id())->get()[0]->id;
            $products = Product::where('seller_id', $sid)->get();
            Log::info('Nimish' . $products . $sid);
            return view('seller.product.list')->with('products', $products);
        }
    }
}
