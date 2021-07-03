<?php

namespace App\Http\Controllers;

use App\Seller;
use App\User;
use App\Product;
use App\Cart;
use App\Address;
use App\Helpers\Notiflix;
use Carbon\Carbon;
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
    public function checkout(Request $req)
    {
        $prod = 0;
        if ($req['type'] == 'buyNow') {
            $prod = $req['id'];
            $buy_now_prod = Product::find($prod);
            $data = [
                'prod_id' => $prod,
                'buy' => 'buyNow',
                'buy_product' => $buy_now_prod,
            ];
        } else {
            $cart_products = Cart::where('user_id', Auth::id())->get();
            $data = [
                'prod_id' => $prod,
                'buy' => $req['type'],
                'cart_products' => $cart_products,
            ];
        }

        return view('profile.checkout')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        LOG::info($req->input());
        LOG::info('BUY Type is' . $req['buy_type']);
        $buy_now_id = 100;
        if ($req['buy_type'] == 'buyNow') {
            $buy_now_id = $req['prod_id'];
        }
        $data = [
            'buy_now_id' => $buy_now_id,
            'addr' => $req['address_radio'],
            'buy_type' => $req['buy_type'],
        ];
        if ($req['payment'] == 'cash') {
            return $this->store($req);
        } else {
            log::info('Going to fetch card details');
            return view('CardDetails')->with($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['buy_type'] == 'buyNow') {
            // log::info('request is' . $request);
            // log::info('request product id is' . $request['prod_id']);
            $products = Product::where('id', $request['prod_id'])->get();
            // Log::info('ProDucts are');
            // log::info($products);
            $current_date_time = Carbon::now()->timestamp;
            $name = User::find(Auth::id())->id;
            $oid = strval($current_date_time) . strval($name);
            $oid_padded = str_pad($oid, 11 - strlen($oid), '0', STR_PAD_LEFT);
            // log::info('PROPERTY EXISTS' . $request['card'] . 'OID IS ' . $oid);
            if ($request['card'] != '') {
                $type = 'card';
            } else {
                $type = 'cod';
            }
            // log::info('typeis' . $type);
            foreach ($products as $p) {
                Order::create([
                    'user_id' => Auth::id(),
                    'product_id' => $p->id,
                    'order_id' => $oid_padded,
                    'address_id' => $request['address_radio'],
                    'qty' => 1,
                    'price' => $p->price,
                    'discount' => $p->discount,
                    'status' => 'Processed',
                    'type' => $type,
                ]);
            }
            // log::info('ORDER PROCESSED SUCCESSFULLY');
            return redirect()
                ->route('orders')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Yippee!',
                        'type' => 'Notify',
                        'subtitle' => 'Order is successfully placed!',
                    ])
                );
            // log::info('request is' . $request);
            // log::info('request product id is' . $request['prod_id']);
            // $products = Product::where('id', $request['prod_id'])->get();
            // Log::info('ProDucts are');
            // log::info($products);
            // $current_date_time = Carbon::now()->timestamp;
            // $name = User::find(Auth::id())->id;
            // $oid = strval($current_date_time) . strval($name);
            // $oid_padded = str_pad($oid, 11 - strlen($oid), '0', STR_PAD_LEFT);
            // log::info('PROPERTY EXISTS' . $request['card'] . 'OID IS ' . $oid);
            // if ($request['card'] != '') {
            //     $type = 'card';
            // } else {
            //     $type = 'cod';
            // }
            // log::info('typeis' . $type);
            // foreach ($products as $p) {
            //     Order::create([
            //         'user_id' => Auth::id(),
            //         'product_id' => $p->id,
            //         'order_id' => $oid_padded,
            //         'address_id' => $request['address_radio'],
            //         'qty' => 1,
            //         'price' => $p->price,
            //         'discount' => $p->discount,
            //         'status' => 'Processed',
            //         'type' => $type,
            //     ]);
            // }
            // log::info('ORDER PROCESSED SUCCESSFULLY');
            // return redirect()
            //     ->route('orders')
            //     ->with(
            //         'alert',
            //         Notiflix::make([
            //             'code' => 'success',
            //             'title' => 'Yippee!',
            //             'type' => 'Notify',
            //             'subtitle' => 'Order is successfully placed!',
            //         ])
            //     );
        } else {
            log::info('request is' . $request);
            $products = Cart::where('user_id', Auth::id())->get();
            $current_date_time = Carbon::now()->timestamp;
            $name = User::find(Auth::id())->id;
            $oid = strval($current_date_time) . strval($name);
            $oid_padded = str_pad($oid, 11 - strlen($oid), '0', STR_PAD_LEFT);
            log::info('PROPERTY EXISTS' . $request['card'] . 'OID IS ' . $oid);
            if ($request['card'] != '') {
                $type = 'card';
            } else {
                $type = 'cod';
            }
            // log::info('typeis' . $type);
            foreach ($products as $p) {
                Order::create([
                    'user_id' => Auth::id(),
                    'product_id' => $p->product_id,
                    'order_id' => $oid_padded,
                    'address_id' => $request['address_radio'],
                    'qty' => $p->qty,
                    'price' => $p->price,
                    'discount' => $p->discount,
                    'status' => 'Processed',
                    'type' => $type,
                ]);
                Cart::find($p->id)->delete();
            }
            // log::info('ORDER PROCESSED SUCCESSFULLY');
            return redirect()
                ->route('orders')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Yippee!',
                        'type' => 'Notify',
                        'subtitle' => 'Order is successfully placed!',
                    ])
                );
        }
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
        $orders = Order::where('user_id', '=', Auth::id())
            ->orderBy('order_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        return view('profile.orders', compact('orders'));
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
    public function cancel_delete(Request $req)
    {
        $ostatus = $req->input('input');
        $oid = $req->input('id');
        $order = Order::all()->where('id',"=",$oid)->first();
        if($ostatus=="Cancel")
        {
            $order->status = 'Cancelled';
            $order->save();
            return redirect()
                ->route('orders.show',$order->order_id)
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Yippee!',
                        'type' => 'Notify',
                        'subtitle' => 'Order is successfully Cancellerd!',
                    ])
                );
        }
        elseif($ostatus=="Delete")
        {
            Order::find($oid)->delete();
            return redirect()
                ->route('orders')
                ->with(
                    'alert',
                    Notiflix::make([
                        'code' => 'success',
                        'title' => 'Yippee!',
                        'type' => 'Notify',
                        'subtitle' => 'Order is successfully Deleted!',
                    ])
                );
        }    
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
