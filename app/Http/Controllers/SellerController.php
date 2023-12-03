<?php

namespace App\Http\Controllers;

use App\Helpers\Notiflix;
use App\Models\Approval;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
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
        if (Auth::user()->is_seller || Auth::user()->is_admin) {
            return redirect()
                ->back()
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
                ->back()
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
    } // test done

    public function index()
    {
        return view('seller.dashboard');
    } // test done

    protected function create_seller(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            // 'gstin' => 'string|size:15',
            'aadhaar' => 'required|string|size:12',
            'trade_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('seller.register.view')
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
            'type' => 'seller_new',
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

    public function product_show($slug)
    {
        $product = Product::where(['slug' => $slug])->first();
        if (!$product) {
            abort(404);
        }
        return view('seller.product.show', compact('product'));
    } // test done

    public function product_orders()
    {
        $product_ids = Auth::user()->seller->products
            ->pluck('id')->toArray();
        $orders = Order::whereIn('product_id', $product_ids)
            ->orderBy('order_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('seller.order.list')->with('orders', $orders);
    } // test done

    public function show_order($id)
    {
        $seller = Auth::user()->seller;
        $product_ids = Product::where('seller_id', $seller->id)
            ->pluck('id')
            ->toArray();
        $orders = $orders = Order::whereIn('product_id', $product_ids)
            ->where('order_id', $id)
            ->get();
        if (count($orders) > 0) {
            return view('seller.order.show', compact('orders'));
        }
        abort(404);
    } // test done

    public function product_browse()
    {
        return view('seller.product.list')->with('products', Auth::user()->seller->products);
    } // test done
}
