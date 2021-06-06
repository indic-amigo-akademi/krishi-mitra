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
use Illuminate\Support\Facades\DB;
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
    public function checkout()
    {
        $buy = 'cart';
        $prod = 100;

        $data = ['buy' => $buy, 'prod_id' => $prod];

        return view('profile.checkout')->with($data);
    }
    public function index1($id)
    {
        log::info('404 not found!!');
        $buy = 'Buy_now';
        $prod = $id;
        $data = ['buy' => $buy, 'prod_id' => $prod];
        return view('profile.checkout')->with($data);
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
                'name' => $req['name'],
                'mobile' => $req['mobile'],
                'pincode' => $req['pincode'],
                'address1' => $req['address1'],
                'address2' => $req['address2'],
                'city' => $req['city'],
                'state' => $req['state'],
                'landmark' => $req['landmark'],
                'type' => $req['type'],
                'user_id' => Auth::id(),
            ]);
        }
        LOG::info('BUY Type is' . $req['buy_type']);
        if ($req['buy_type'] == 'Buy_now') {
            return $this->buy_now($req['prod_id']);
            //return redirect('/checkout/processed/buynow/' . $req['prod_id']);
        } else {
            if ($req['optradio'] == 'COD') {
                return redirect(route('OrderProcessed'));
            } else {
                return view('CardDetails');
            }
        }
    }
    protected function buy_now($id)
    {
        $p = Product::find($id);
        log::info('Product id is' . $p);
        $oid = rand(1, 999999999);
        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $p->id,
            'order_id' => $oid,
            'qty' => 1,
            'price' => $p->price * (1 - $p->discount),
            'discount' => $p->discount,
            'status' => 'Processed',
            'type' => 'cod',
        ]);
        log::info('ORDER PROCESSED SUCCESSFULLY FOR BUY NOW');
        return redirect(route('home'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = Cart::where('user_id', Auth::id())->get();
        $oid = rand(1, 999999999);
        log::info('PROPERTY EXISTS' . $request['card']);
        if ($request['card'] != '') {
            $type = 'card';
        } else {
            $type = 'cod';
        }
        log::info('typeis' . $type);
        foreach ($products as $p) {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $p->product_id,
                'order_id' => $oid,
                'qty' => $p->qty,
                'price' => $p->qty * $p->price * (1 - $p->discount),
                'discount' => $p->discount,
                'status' => 'Processed',
                'type' => $type,
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
    public function showall()
    {
        /*$ord = Cart::select('order_id')::where('user_id', Auth::id())->get();*/
        $ord = DB::table('orders')
            ->where('user_id', '=', Auth::id())
            ->select([
                DB::raw('order_id'),
                DB::raw("SUM(price) as 'tot'"),
                DB::raw('max(created_at) as created_at'),
            ])
            ->groupBy('order_id')
            ->orderBy('created_at')
            ->get();
        return view('profile.orders')->with('ord', $ord);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showone($id)
    {
        $orders = Order::where([
            'user_id' => Auth::id(),
            'order_id' => $id,
        ])->get();
        if (count($orders) > 0) {
            return view('profile.order', compact('orders'));
        }
        abort(404);
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
